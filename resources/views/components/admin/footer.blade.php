</div> {{-- Penutup class content --}}

<footer class="footer">
    <div class="container-fluid">
        <nav class="pull-left">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Website Kelurahan
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright ml-auto">
            <i class="far fa-copyright mr-1"></i>{{ date('Y') }} Crafted by Team Vanguard
        </div>
    </div>
</footer>
</div> {{-- Penutup main-panel --}}
</div> {{-- Penutup wrapper --}}

<script src="{{ asset('assets/admin/js/core/jquery.3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/core/bootstrap.min.js') }}"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>

<script src="{{ asset('assets/admin/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugin/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugin/chart-circle/circles.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<script src="{{ asset('assets/admin/js/atlantis.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/custom.js?v=2') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        updateVideoPreview(); // Jalankan preview saat halaman dimuat
    });

    function getYoutubeVideoId(url) {
        let videoId = null;
        const regExp = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i;
        const match = url.match(regExp);
        if (match && match[1]) {
            videoId = match[1];
        }
        return videoId;
    }

    function updateVideoPreview() {
        const url = document.getElementById('youtube_link').value;
        const container = document.getElementById('video_preview_container');
        const iframe = document.getElementById('video_preview');
        const msg = document.getElementById('video_preview_message');
        const videoId = getYoutubeVideoId(url);

        if (videoId) {
            iframe.src = `https://www.youtube.com/embed/${videoId}`;
            container.classList.remove('d-none');
            msg.classList.add('d-none');
        } else {
            iframe.src = "";
            container.classList.add('d-none');
            msg.classList.remove('d-none');
            if (url) {
                msg.textContent = 'Link YouTube tidak valid.';
                msg.className = 'text-danger small mt-2';
            } else {
                msg.textContent = 'Masukkan link YouTube untuk melihat preview.';
                msg.className = 'text-muted small mt-2';
            }
        }
    }
</script>
</body>

</html>
