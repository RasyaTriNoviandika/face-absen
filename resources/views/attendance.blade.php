<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Absensi Wajah</title>
    @vite(['resources/css/app.css'])
    
    <!-- Face-API.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-t-2xl shadow-2xl p-6 text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Sistem Absensi Wajah</h1>
                <p class="text-gray-600">Silakan arahkan wajah Anda ke kamera</p>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-b-2xl shadow-2xl p-6">
                <!-- Loading State -->
                <div id="loading" class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                    <p class="mt-4 text-gray-600">Loading AI Models...</p>
                </div>

                <!-- Camera Container -->
                <div id="camera-container" class="hidden">
                    <div class="relative bg-gray-900 rounded-lg overflow-hidden">
                        <video id="video" autoplay muted playsinline class="w-full h-96 object-cover"></video>
                        <canvas id="overlay" class="absolute top-0 left-0 w-full h-full"></canvas>
                        
                        <!-- Status Badge -->
                        <div id="status" class="absolute top-4 right-4 bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold">
                            Mencari Wajah...
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <button id="checkInBtn" class="bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-lg text-lg disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                            Check In
                        </button>
                        <button id="checkOutBtn" class="bg-red-500 hover:bg-red-600 text-white font-bold py-4 rounded-lg text-lg disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                            Check Out
                        </button>
                    </div>
                </div>

                <!-- Result Message -->
                <div id="result" class="mt-6 hidden"></div>
            </div>
        </div>
    </div>

    <script>
        let videoEl, canvasEl, statusEl, checkInBtn, checkOutBtn;
        let currentEmployee = null;
        let labeledDescriptors = [];
        let recognitionInterval = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', async () => {
            videoEl = document.getElementById('video');
            canvasEl = document.getElementById('overlay');
            statusEl = document.getElementById('status');
            checkInBtn = document.getElementById('checkInBtn');
            checkOutBtn = document.getElementById('checkOutBtn');

            try {
                // Load Face-API models
                await loadModels();
                
                // Load registered faces from database
                await loadRegisteredFaces();
                
                // Start camera
                await startCamera();
                
                // Hide loading, show camera
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('camera-container').classList.remove('hidden');
                
                // Start face detection
                startFaceRecognition();
                
            } catch (error) {
                console.error('Initialization error:', error);
                alert('Gagal memulai sistem: ' + error.message);
            }
        });

        // Load Face-API Models
        async function loadModels() {
            const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1.7.12/model';
            
            await faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL);
            await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
            await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);
            
            console.log('Models loaded successfully');
        }

        // Load registered faces from database
        async function loadRegisteredFaces() {
            try {
                const response = await fetch('/api/face/registered');
                const data = await response.json();
                
                labeledDescriptors = data.map(item => {
                    const descriptors = [new Float32Array(item.descriptor)];
                    return new faceapi.LabeledFaceDescriptors(
                        item.employee_nip,
                        descriptors
                    );
                });
                
                console.log(`Loaded ${labeledDescriptors.length} registered faces`);
            } catch (error) {
                console.error('Error loading registered faces:', error);
                throw new Error('Gagal memuat data wajah terdaftar');
            }
        }

        // Start camera
        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { width: 640, height: 480 } 
                });
                videoEl.srcObject = stream;
                
                return new Promise((resolve) => {
                    videoEl.onloadedmetadata = () => {
                        // Set canvas size
                        canvasEl.width = videoEl.videoWidth;
                        canvasEl.height = videoEl.videoHeight;
                        resolve();
                    };
                });
            } catch (error) {
                console.error('Camera error:', error);
                throw new Error('Tidak dapat mengakses kamera');
            }
        }

        // Start face recognition loop
        function startFaceRecognition() {
            recognitionInterval = setInterval(async () => {
                try {
                    await detectAndRecognizeFace();
                } catch (error) {
                    console.error('Recognition error:', error);
                }
            }, 500); // Check every 500ms
        }

        // Detect and recognize face
        async function detectAndRecognizeFace() {
            const detections = await faceapi
                .detectAllFaces(videoEl)
                .withFaceLandmarks()
                .withFaceDescriptors();

            // Clear canvas
            const ctx = canvasEl.getContext('2d');
            ctx.clearRect(0, 0, canvasEl.width, canvasEl.height);

            if (detections.length === 0) {
                statusEl.textContent = 'Mencari Wajah...';
                statusEl.className = 'absolute top-4 right-4 bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold';
                currentEmployee = null;
                checkInBtn.disabled = true;
                checkOutBtn.disabled = true;
                return;
            }

            // Create face matcher
            const faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.6);

            // Resize detections to match canvas
            const resizedDetections = faceapi.resizeResults(detections, {
                width: canvasEl.width,
                height: canvasEl.height
            });

            // Find best match
            const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor));

            // Draw detections
            resizedDetections.forEach((detection, i) => {
                const box = detection.detection.box;
                const drawBox = new faceapi.draw.DrawBox(box, {
                    label: results[i].toString(),
                    boxColor: results[i].label === 'unknown' ? 'red' : 'green'
                });
                drawBox.draw(canvasEl);
            });

            // Handle recognition result
            const bestMatch = results[0];
            if (bestMatch.label !== 'unknown') {
                const employee = await getEmployeeByNIP(bestMatch.label);
                if (employee) {
                    currentEmployee = employee;
                    statusEl.textContent = `Wajah Terdeteksi: ${employee.name}`;
                    statusEl.className = 'absolute top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg font-semibold';
                    checkInBtn.disabled = false;
                    checkOutBtn.disabled = false;
                }
            } else {
                statusEl.textContent = 'Wajah Tidak Dikenali';
                statusEl.className = 'absolute top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg font-semibold';
                currentEmployee = null;
                checkInBtn.disabled = true;
                checkOutBtn.disabled = true;
            }
        }

        // Get employee by NIP
        async function getEmployeeByNIP(nip) {
            const response = await fetch('/api/face/registered');
            const data = await response.json();
            return data.find(emp => emp.employee_nip === nip);
        }

        // Capture photo from video
        function capturePhoto() {
            const canvas = document.createElement('canvas');
            canvas.width = videoEl.videoWidth;
            canvas.height = videoEl.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(videoEl, 0, 0);
            return canvas.toDataURL('image/png');
        }

        // Check In
        checkInBtn.addEventListener('click', async () => {
            if (!currentEmployee) return;

            checkInBtn.disabled = true;
            checkInBtn.textContent = 'Processing...';

            try {
                const photo = capturePhoto();
                const response = await fetch('/api/face/check-in', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        employee_id: currentEmployee.employee_id,
                        photo: photo
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showResult('success', `Check-in berhasil! Selamat bekerja, ${currentEmployee.employee_name}`, result.data);
                } else {
                    showResult('error', result.message);
                }
            } catch (error) {
                showResult('error', 'Terjadi kesalahan: ' + error.message);
            } finally {
                checkInBtn.disabled = false;
                checkInBtn.textContent = 'Check In';
            }
        });

        // Check Out
        checkOutBtn.addEventListener('click', async () => {
            if (!currentEmployee) return;

            checkOutBtn.disabled = true;
            checkOutBtn.textContent = 'Processing...';

            try {
                const photo = capturePhoto();
                const response = await fetch('/api/face/check-out', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        employee_id: currentEmployee.employee_id,
                        photo: photo
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showResult('success', `Check-out berhasil! Terima kasih, ${currentEmployee.employee_name}`, result.data);
                } else {
                    showResult('error', result.message);
                }
            } catch (error) {
                showResult('error', 'Terjadi kesalahan: ' + error.message);
            } finally {
                checkOutBtn.disabled = false;
                checkOutBtn.textContent = 'Check Out';
            }
        });

        // Show result message
        function showResult(type, message, data = null) {
            const resultEl = document.getElementById('result');
            resultEl.classList.remove('hidden');
            
            const bgColor = type === 'success' ? 'bg-green-100 border-green-500 text-green-800' : 'bg-red-100 border-red-500 text-red-800';
            
            let html = `
                <div class="border-l-4 ${bgColor} p-4 rounded">
                    <p class="font-bold">${message}</p>
            `;
            
            if (data) {
                html += `
                    <p class="mt-2 text-sm">Waktu: ${data.time}</p>
                    <p class="text-sm">Status: ${data.status || data.attendance.status}</p>
                `;
            }
            
            html += `</div>`;
            resultEl.innerHTML = html;

            // Auto hide after 5 seconds
            setTimeout(() => {
                resultEl.classList.add('hidden');
            }, 5000);
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (recognitionInterval) {
                clearInterval(recognitionInterval);
            }
            if (videoEl.srcObject) {
                videoEl.srcObject.getTracks().forEach(track => track.stop());
            }
        });
    </script>
</body>
</html>