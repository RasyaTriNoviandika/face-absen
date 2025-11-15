<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Absensi Wajah - FaceAttend</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    <style>
        @keyframes pulse-ring {
            0% {
                transform: scale(0.95);
                opacity: 1;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.7;
            }
            100% {
                transform: scale(0.95);
                opacity: 1;
            }
        }
        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes scan {
            0%, 100% {
                transform: translateY(-100%);
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
        }
        .scan-line {
            animation: scan 2s linear infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 min-h-screen">
    
    <!-- Navbar -->
    <nav class="bg-black/20 backdrop-blur-lg border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">FaceAttend</span>
                </div>
                <a href="/" class="text-white/80 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            
            <!-- Header Card -->
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl shadow-2xl p-8 mb-6 border border-white/20">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-white mb-3">Sistem Absensi Wajah</h1>
                    <p class="text-white/80 text-lg">Arahkan wajah Anda ke kamera untuk verifikasi</p>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loading" class="bg-white/10 backdrop-blur-lg rounded-3xl shadow-2xl p-12 border border-white/20">
                <div class="flex flex-col items-center justify-center">
                    <div class="relative">
                        <div class="w-24 h-24 border-8 border-white/20 rounded-full"></div>
                        <div class="w-24 h-24 border-8 border-t-white border-r-transparent border-b-transparent border-l-transparent rounded-full animate-spin absolute top-0 left-0"></div>
                    </div>
                    <p class="mt-6 text-white text-xl font-semibold">Memuat AI Models...</p>
                    <p class="mt-2 text-white/60">Mohon tunggu sebentar</p>
                </div>
            </div>

            <!-- Camera Container -->
            <div id="camera-container" class="hidden space-y-6">
                
                <!-- Video Card -->
                <div class="bg-white/10 backdrop-blur-lg rounded-3xl shadow-2xl overflow-hidden border border-white/20">
                    <div class="relative bg-black/50">
                        <!-- Video Element -->
                        <video id="video" autoplay muted playsinline class="w-full h-[500px] object-cover"></video>
                        
                        <!-- Canvas Overlay -->
                        <canvas id="overlay" class="absolute top-0 left-0 w-full h-full"></canvas>
                        
                        <!-- Scan Line Effect -->
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-indigo-400 to-transparent scan-line"></div>
                        
                        <!-- Corner Decorations -->
                        <div class="absolute top-4 left-4 w-16 h-16 border-t-4 border-l-4 border-indigo-400 rounded-tl-2xl"></div>
                        <div class="absolute top-4 right-4 w-16 h-16 border-t-4 border-r-4 border-indigo-400 rounded-tr-2xl"></div>
                        <div class="absolute bottom-4 left-4 w-16 h-16 border-b-4 border-l-4 border-indigo-400 rounded-bl-2xl"></div>
                        <div class="absolute bottom-4 right-4 w-16 h-16 border-b-4 border-r-4 border-indigo-400 rounded-br-2xl"></div>
                        
                        <!-- Status Badge -->
                        <div id="status" class="absolute top-6 right-6 px-6 py-3 rounded-2xl font-semibold shadow-lg backdrop-blur-lg border-2 border-white/20 transition-all duration-300">
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-yellow-400 animate-pulse"></span>
                                <span class="text-white">Mencari Wajah...</span>
                            </div>
                        </div>
                        
                        <!-- Info Overlay -->
                        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 bg-black/70 backdrop-blur-lg px-6 py-3 rounded-2xl border border-white/20">
                            <p class="text-white text-sm font-medium">Posisikan wajah di tengah kamera</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button id="checkInBtn" disabled class="group relative overflow-hidden bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold py-6 rounded-2xl text-xl shadow-xl hover:shadow-2xl transition-all duration-300 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed disabled:hover:shadow-xl">
                        <div class="relative z-10 flex items-center justify-center space-x-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Check In</span>
                        </div>
                        <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
                    </button>
                    
                    <button id="checkOutBtn" disabled class="group relative overflow-hidden bg-gradient-to-r from-red-500 to-pink-600 text-white font-bold py-6 rounded-2xl text-xl shadow-xl hover:shadow-2xl transition-all duration-300 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed disabled:hover:shadow-xl">
                        <div class="relative z-10 flex items-center justify-center space-x-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Check Out</span>
                        </div>
                        <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
                    </button>
                </div>

                <!-- Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-indigo-500/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white/60 text-sm">Akurasi</p>
                                <p class="text-white text-xl font-bold">99.9%</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-purple-500/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white/60 text-sm">Kecepatan</p>
                                <p class="text-white text-xl font-bold">< 2 detik</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-pink-500/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white/60 text-sm">Keamanan</p>
                                <p class="text-white text-xl font-bold">Tinggi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Result Message -->
            <div id="result" class="hidden mt-6"></div>

        </div>
    </div>

    <script>
    let videoEl, canvasEl, statusEl, checkInBtn, checkOutBtn;
    let currentEmployee = null;
    let labeledDescriptors = [];
    let recognitionInterval = null;
    let modelsLoaded = false;

    document.addEventListener('DOMContentLoaded', async () => {
        videoEl = document.getElementById('video');
        canvasEl = document.getElementById('overlay');
        statusEl = document.getElementById('status');
        checkInBtn = document.getElementById('checkInBtn');
        checkOutBtn = document.getElementById('checkOutBtn');

        console.log('Starting face recognition system...');

        try {
            await loadModels();
            console.log('Models loaded successfully');
            
            await loadRegisteredFaces();
            console.log('Registered faces loaded:', labeledDescriptors.length);
            
            await startCamera();
            console.log('Camera started');
            
            document.getElementById('loading').classList.add('hidden');
            document.getElementById('camera-container').classList.remove('hidden');
            
            // Start recognition
            startFaceRecognition();
            
        } catch (error) {
            console.error('Initialization Error:', error);
            showNotification('error', 'Gagal memulai sistem: ' + error.message);
            document.getElementById('loading').innerHTML = `
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="mt-4 text-white text-lg font-semibold">Error: ${error.message}</p>
                    <button onclick="location.reload()" class="mt-4 px-6 py-2 bg-white text-indigo-600 rounded-lg hover:bg-gray-100 transition-colors">
                        Coba Lagi
                    </button>
                </div>
            `;
        }
    });

    async function loadModels() {
        const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1.7.12/model';
        
        try {
            await Promise.all([
                faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL),
                faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
            ]);
            modelsLoaded = true;
            console.log('All models loaded');
        } catch (error) {
            console.error('Model loading error:', error);
            throw new Error('Gagal memuat AI models. Periksa koneksi internet Anda.');
        }
    }

    async function loadRegisteredFaces() {
        try {
            const response = await fetch('/api/face/registered');
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            console.log('Fetched registered faces:', data);
            
            if (!Array.isArray(data) || data.length === 0) {
                console.warn('No registered faces found');
                updateStatus('no-faces');
                return;
            }
            
            labeledDescriptors = data.map(item => {
                const descriptors = [new Float32Array(item.descriptor)];
                return new faceapi.LabeledFaceDescriptors(item.employee_nip, descriptors);
            });
            
            console.log('Labeled descriptors created:', labeledDescriptors.length);
        } catch (error) {
            console.error('Error loading registered faces:', error);
            throw new Error('Gagal memuat data wajah terdaftar: ' + error.message);
        }
    }

    async function startCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    width: { ideal: 1280 },
                    height: { ideal: 720 },
                    facingMode: 'user'
                } 
            });
            
            videoEl.srcObject = stream;
            
            return new Promise((resolve, reject) => {
                videoEl.onloadedmetadata = () => {
                    videoEl.play();
                    canvasEl.width = videoEl.videoWidth;
                    canvasEl.height = videoEl.videoHeight;
                    console.log('Video dimensions:', videoEl.videoWidth, 'x', videoEl.videoHeight);
                    resolve();
                };
                
                videoEl.onerror = () => {
                    reject(new Error('Gagal memuat video dari kamera'));
                };
                
                // Timeout jika video tidak load dalam 10 detik
                setTimeout(() => {
                    if (videoEl.readyState < 2) {
                        reject(new Error('Kamera timeout. Pastikan kamera tidak digunakan aplikasi lain.'));
                    }
                }, 10000);
            });
        } catch (error) {
            console.error('Camera error:', error);
            if (error.name === 'NotAllowedError') {
                throw new Error('Akses kamera ditolak. Izinkan akses kamera di browser Anda.');
            } else if (error.name === 'NotFoundError') {
                throw new Error('Kamera tidak ditemukan. Pastikan kamera terhubung.');
            } else {
                throw new Error('Gagal mengakses kamera: ' + error.message);
            }
        }
    }

    function startFaceRecognition() {
        if (recognitionInterval) {
            clearInterval(recognitionInterval);
        }
        
        console.log('Starting face recognition loop...');
        recognitionInterval = setInterval(async () => {
            await detectAndRecognizeFace();
        }, 500);
    }

    async function detectAndRecognizeFace() {
        if (!modelsLoaded || videoEl.readyState !== 4) {
            return;
        }

        try {
            const detections = await faceapi
                .detectAllFaces(videoEl, new faceapi.SsdMobilenetv1Options({ minConfidence: 0.5 }))
                .withFaceLandmarks()
                .withFaceDescriptors();

            const ctx = canvasEl.getContext('2d');
            ctx.clearRect(0, 0, canvasEl.width, canvasEl.height);

            if (detections.length === 0) {
                updateStatus('searching');
                currentEmployee = null;
                checkInBtn.disabled = true;
                checkOutBtn.disabled = true;
                return;
            }

            // Check if faces are registered
            if (labeledDescriptors.length === 0) {
                updateStatus('no-faces');
                currentEmployee = null;
                checkInBtn.disabled = true;
                checkOutBtn.disabled = true;
                return;
            }

            const faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.6);
            const resizedDetections = faceapi.resizeResults(detections, {
                width: canvasEl.width,
                height: canvasEl.height
            });
            
            const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor));

            // Draw detections
            resizedDetections.forEach((detection, i) => {
                const box = detection.detection.box;
                const drawBox = new faceapi.draw.DrawBox(box, {
                    label: results[i].toString(),
                    boxColor: results[i].label === 'unknown' ? '#ef4444' : '#10b981',
                    lineWidth: 2
                });
                drawBox.draw(canvasEl);
            });

            // Check first match
            const bestMatch = results[0];
            if (bestMatch.label !== 'unknown' && bestMatch.distance < 0.6) {
                const employee = await getEmployeeByNIP(bestMatch.label);
                if (employee) {
                    currentEmployee = employee;
                    updateStatus('recognized', employee.employee_name);
                    checkInBtn.disabled = false;
                    checkOutBtn.disabled = false;
                } else {
                    updateStatus('unknown');
                    currentEmployee = null;
                    checkInBtn.disabled = true;
                    checkOutBtn.disabled = true;
                }
            } else {
                updateStatus('unknown');
                currentEmployee = null;
                checkInBtn.disabled = true;
                checkOutBtn.disabled = true;
            }
        } catch (error) {
            console.error('Recognition error:', error);
        }
    }

    function updateStatus(type, name = '') {
        const statuses = {
            searching: {
                html: `<span class="w-3 h-3 rounded-full bg-yellow-400 animate-pulse"></span><span class="text-white">Mencari Wajah...</span>`,
                classes: 'bg-yellow-500/30 border-yellow-400/50'
            },
            recognized: {
                html: `<span class="w-3 h-3 rounded-full bg-green-400"></span><span class="text-white">Terdeteksi: ${name}</span>`,
                classes: 'bg-green-500/30 border-green-400/50'
            },
            unknown: {
                html: `<span class="w-3 h-3 rounded-full bg-red-400"></span><span class="text-white">Wajah Tidak Dikenali</span>`,
                classes: 'bg-red-500/30 border-red-400/50'
            },
            'no-faces': {
                html: `<span class="w-3 h-3 rounded-full bg-orange-400"></span><span class="text-white">Belum Ada Wajah Terdaftar</span>`,
                classes: 'bg-orange-500/30 border-orange-400/50'
            }
        };
        
        const status = statuses[type];
        statusEl.className = `absolute top-6 right-6 px-6 py-3 rounded-2xl font-semibold shadow-lg backdrop-blur-lg border-2 transition-all duration-300 ${status.classes}`;
        statusEl.innerHTML = `<div class="flex items-center space-x-2">${status.html}</div>`;
    }

    async function getEmployeeByNIP(nip) {
        try {
            const response = await fetch('/api/face/registered');
            const data = await response.json();
            return data.find(emp => emp.employee_nip === nip);
        } catch (error) {
            console.error('Error getting employee:', error);
            return null;
        }
    }

    function capturePhoto() {
        const canvas = document.createElement('canvas');
        canvas.width = videoEl.videoWidth;
        canvas.height = videoEl.videoHeight;
        canvas.getContext('2d').drawImage(videoEl, 0, 0);
        return canvas.toDataURL('image/png');
    }

    function showNotification(type, message, data = null) {
        const resultEl = document.getElementById('result');
        resultEl.classList.remove('hidden');
        
        const colors = {
            success: 'from-green-500 to-emerald-600',
            error: 'from-red-500 to-pink-600'
        };
        
        const icon = type === 'success' 
            ? '<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
            : '<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        
        resultEl.innerHTML = `
            <div class="bg-gradient-to-r ${colors[type]} rounded-3xl p-6 shadow-2xl border border-white/20 backdrop-blur-lg">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">${icon}</div>
                    <div class="flex-1">
                        <p class="text-white font-bold text-xl mb-2">${message}</p>
                        ${data ? `
                            <div class="space-y-1 text-white/80">
                                <p>Waktu: ${data.time}</p>
                                <p>Status: ${data.status || data.attendance?.status || '-'}</p>
                            </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;

        setTimeout(() => {
            resultEl.classList.add('hidden');
        }, 5000);
    }

    checkInBtn.addEventListener('click', async () => {
        if (!currentEmployee) {
            showNotification('error', 'Tidak ada wajah yang terdeteksi');
            return;
        }
        
        checkInBtn.disabled = true;
        const originalText = checkInBtn.innerHTML;
        checkInBtn.innerHTML = '<span class="animate-pulse">Memproses...</span>';

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
                showNotification('success', `Check-in berhasil! Selamat bekerja, ${currentEmployee.employee_name}`, result.data);
            } else {
                showNotification('error', result.message || 'Check-in gagal');
            }
        } catch (error) {
            console.error('Check-in error:', error);
            showNotification('error', 'Terjadi kesalahan: ' + error.message);
        } finally {
            checkInBtn.innerHTML = originalText;
            checkInBtn.disabled = false;
        }
    });

    checkOutBtn.addEventListener('click', async () => {
        if (!currentEmployee) {
            showNotification('error', 'Tidak ada wajah yang terdeteksi');
            return;
        }
        
        checkOutBtn.disabled = true;
        const originalText = checkOutBtn.innerHTML;
        checkOutBtn.innerHTML = '<span class="animate-pulse">Memproses...</span>';

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
                showNotification('success', `Check-out berhasil! Terima kasih, ${currentEmployee.employee_name}`, result.data);
            } else {
                showNotification('error', result.message || 'Check-out gagal');
            }
        } catch (error) {
            console.error('Check-out error:', error);
            showNotification('error', 'Terjadi kesalahan: ' + error.message);
        } finally {
            checkOutBtn.innerHTML = originalText;
            checkOutBtn.disabled = false;
        }
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        if (recognitionInterval) {
            clearInterval(recognitionInterval);
        }
        if (videoEl && videoEl.srcObject) {
            videoEl.srcObject.getTracks().forEach(track => track.stop());
        }
    });
</script>
</body>
</html>