@extends('layouts.admin')

@section('title', 'Registrasi Wajah - ' . $employee->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Registrasi Wajah</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $employee->name }} ({{ $employee->nip }})</p>
                </div>
                <a href="{{ route('admin.employees.show', $employee) }}" class="text-sm text-gray-600 hover:text-gray-900">
                    ← Kembali
                </a>
            </div>
        </div>

        <div class="p-6">
            <!-- Loading State -->
            <div id="loading" class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                <p class="mt-4 text-gray-600">Memuat AI Models...</p>
            </div>

            <!-- Camera Container -->
            <div id="camera-container" class="hidden">
                <div class="relative bg-black rounded-xl overflow-hidden mb-6">
                    <video id="video" autoplay muted playsinline class="w-full h-96 object-cover"></video>
                    <canvas id="overlay" class="absolute top-0 left-0 w-full h-full"></canvas>
                    
                    <div id="status" class="absolute top-4 right-4 px-4 py-2 rounded-lg font-semibold shadow-lg backdrop-blur-lg border-2">
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                            <span class="text-white text-sm">Mencari Wajah...</span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">Petunjuk Registrasi Wajah:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>Pastikan wajah Anda menghadap kamera dengan jelas</li>
                                <li>Posisikan wajah di tengah frame kamera</li>
                                <li>Pastikan pencahayaan cukup terang</li>
                                <li>Tunggu hingga wajah terdeteksi (kotak hijau muncul)</li>
                                <li>Klik tombol "Daftarkan Wajah" untuk menyimpan</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <button id="registerBtn" disabled 
                        class="w-full px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors font-semibold disabled:bg-gray-400 disabled:cursor-not-allowed">
                    Daftarkan Wajah
                </button>
            </div>

            <!-- Result Message -->
            <div id="result" class="hidden mt-6"></div>
        </div>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
<script>
let videoEl, canvasEl, statusEl, registerBtn;
let faceDetected = false;
let currentDescriptor = null;
let detectionInterval = null;

document.addEventListener('DOMContentLoaded', async () => {
    videoEl = document.getElementById('video');
    canvasEl = document.getElementById('overlay');
    statusEl = document.getElementById('status');
    registerBtn = document.getElementById('registerBtn');

    try {
        await loadModels();
        await startCamera();
        
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('camera-container').classList.remove('hidden');
        
        startFaceDetection();
        
        // ✅ TAMBAHKAN: Event listener untuk tombol register
        registerBtn.addEventListener('click', handleRegister);
        
    } catch (error) {
        console.error('Error:', error);
        showNotification('error', 'Gagal memulai kamera: ' + error.message);
    }
});

async function loadModels() {
    const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1.7.12/model';
    await Promise.all([
        faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL),
        faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
        faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
    ]);
}

async function startCamera() {
    const stream = await navigator.mediaDevices.getUserMedia({ 
        video: { width: 640, height: 480 } 
    });
    videoEl.srcObject = stream;
    
    return new Promise((resolve) => {
        videoEl.onloadedmetadata = () => {
            canvasEl.width = videoEl.videoWidth;
            canvasEl.height = videoEl.videoHeight;
            resolve();
        };
    });
}

function startFaceDetection() {
    detectionInterval = setInterval(async () => {
        const detections = await faceapi
            .detectAllFaces(videoEl, new faceapi.SsdMobilenetv1Options({ minConfidence: 0.5 }))
            .withFaceLandmarks()
            .withFaceDescriptors();

        const ctx = canvasEl.getContext('2d');
        ctx.clearRect(0, 0, canvasEl.width, canvasEl.height);

        if (detections.length === 0) {
            updateStatus('searching');
            faceDetected = false;
            registerBtn.disabled = true;
            currentDescriptor = null;
            return;
        }

        if (detections.length > 1) {
            updateStatus('multiple');
            faceDetected = false;
            registerBtn.disabled = true;
            currentDescriptor = null;
            return;
        }

        const detection = detections[0];
        const resizedDetection = faceapi.resizeResults(detection, {
            width: canvasEl.width,
            height: canvasEl.height
        });

        const box = resizedDetection.detection.box;
        const drawBox = new faceapi.draw.DrawBox(box, {
            label: 'Wajah Terdeteksi',
            boxColor: '#10b981',
            lineWidth: 3
        });
        drawBox.draw(canvasEl);

        updateStatus('detected');
        faceDetected = true;
        registerBtn.disabled = false;
        currentDescriptor = Array.from(detection.descriptor);
    }, 500);
}

function updateStatus(type) {
    const statuses = {
        searching: {
            html: '<span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span><span class="text-white text-sm">Mencari Wajah...</span>',
            classes: 'bg-yellow-500/80 border-yellow-400'
        },
        detected: {
            html: '<span class="w-2 h-2 rounded-full bg-green-400"></span><span class="text-white text-sm">Wajah Terdeteksi!</span>',
            classes: 'bg-green-500/80 border-green-400'
        },
        multiple: {
            html: '<span class="w-2 h-2 rounded-full bg-red-400"></span><span class="text-white text-sm">Terlalu Banyak Wajah</span>',
            classes: 'bg-red-500/80 border-red-400'
        }
    };
    
    const status = statuses[type];
    statusEl.className = `absolute top-4 right-4 px-4 py-2 rounded-lg font-semibold shadow-lg backdrop-blur-md border-2 ${status.classes}`;
    statusEl.innerHTML = `<div class="flex items-center space-x-2">${status.html}</div>`;
}

function capturePhoto() {
    const canvas = document.createElement('canvas');
    canvas.width = videoEl.videoWidth;
    canvas.height = videoEl.videoHeight;
    canvas.getContext('2d').drawImage(videoEl, 0, 0);
    return canvas.toDataURL('image/png');
}

function showNotification(type, message) {
    const resultEl = document.getElementById('result');
    resultEl.classList.remove('hidden');
    
    const colors = type === 'success' 
        ? 'bg-green-50 border-green-200 text-green-800' 
        : 'bg-red-50 border-red-200 text-red-800';
    
    const icon = type === 'success'
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
    
    resultEl.innerHTML = `
        <div class="${colors} border rounded-xl p-4">
            <div class="flex">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${icon}
                </svg>
                <p class="font-medium">${message}</p>
            </div>
        </div>
    `;

    if (type === 'success') {
        setTimeout(() => {
            window.location.href = "{{ route('admin.employees.show', $employee) }}";
        }, 2000);
    }
}

// ✅ PERBAIKAN UTAMA: Function handleRegister
async function handleRegister() {
    if (!faceDetected || !currentDescriptor) {
        showNotification('error', 'Wajah tidak terdeteksi dengan jelas');
        return;
    }

    registerBtn.disabled = true;
    const originalText = registerBtn.textContent;
    registerBtn.textContent = 'Memproses...';

    try {
        const photo = capturePhoto();
        
        const response = await fetch('/api/face/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                employee_id: {{ $employee->id }},
                descriptor: currentDescriptor,
                photo: photo
            })
        });

        const result = await response.json();
        
        if (result.success) {
            clearInterval(detectionInterval);
            if (videoEl.srcObject) {
                videoEl.srcObject.getTracks().forEach(track => track.stop());
            }
            showNotification('success', 'Wajah berhasil didaftarkan! Mengalihkan...');
        } else {
            showNotification('error', result.message || 'Gagal mendaftarkan wajah');
            registerBtn.disabled = false;
            registerBtn.textContent = originalText;
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('error', 'Terjadi kesalahan: ' + error.message);
        registerBtn.disabled = false;
        registerBtn.textContent = originalText;
    }
}

window.addEventListener('beforeunload', () => {
    if (detectionInterval) clearInterval(detectionInterval);
    if (videoEl && videoEl.srcObject) {
        videoEl.srcObject.getTracks().forEach(track => track.stop());
    }
});
</script>
@endsection