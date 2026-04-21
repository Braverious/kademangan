// assets/admin/js/custom.js

(function ($) {
  $(function () {
    var $tbl = $('#basic-datatables');

    // Table ada? plugin ada? sudah pernah init?
    if ($tbl.length && typeof $.fn.DataTable === 'function' && !$.fn.DataTable.isDataTable($tbl)) {
      $tbl.DataTable({
        pageLength: 10,
        lengthChange: false,
        ordering: true,
        order: [[0, 'asc']],
        language: {
          emptyTable:   "Belum ada data.",
          zeroRecords:  "Belum ada data yang cocok.",
          info:         "Menampilkan _START_–_END_ dari _TOTAL_ entri",
          infoEmpty:    "Menampilkan 0 entri",
          infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
          search:       "Cari:",
          paginate: { first:"Pertama", previous:"Sebelumnya", next:"Berikutnya", last:"Terakhir" },
          lengthMenu:   "Tampilkan _MENU_ entri",
          processing:   "Memproses..."
        }
      });
    } else if (!$tbl.length) {
      // no-op: halaman ini tidak punya #basic-datatables
    } else if (typeof $.fn.DataTable !== 'function') {
      console.warn('DataTables belum termuat. Cek urutan <script>.');
    }
  });
})(jQuery);

/* =========================================================
   CUSTOM SCRIPT: IMAGE UPLOAD PREVIEW (JANGKAUAN LAYANAN)
   ========================================================= */

document.addEventListener('DOMContentLoaded', function() {
    
    // Tangkap semua input file yang memiliki class spesifik ini
    const fileInputs = document.querySelectorAll('.coverage-file-input');

    fileInputs.forEach(function(input) {
        input.addEventListener('change', function(e) {
            
            // Ambil ID tujuan preview dari attribute data-preview
            const targetPreviewId = this.getAttribute('data-preview');
            const previewElement = document.getElementById(targetPreviewId);
            
            // Cek apakah ada file yang dipilih
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    // Masukkan base64 image ke source img
                    previewElement.src = event.target.result;
                    // Tampilkan element img
                    previewElement.classList.remove('d-none');
                }
                
                // Mulai membaca file
                reader.readAsDataURL(this.files[0]);
            } else {
                // Jika user batal memilih file (Cancel)
                previewElement.src = "";
                previewElement.classList.add('d-none');
            }
        });
    });
    
});

// 1. Cek dulu apakah ada elemen #isi_berita di halaman ini
let textareaBerita = document.querySelector('#isi_berita');
    
// 2. Jalankan CKEditor HANYA jika elemennya ada (mencegah error di Dashboard)
if (textareaBerita) {
    let ck;
    ClassicEditor.create(textareaBerita, {
        language: 'id',
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', 'link', '|',
                'bulletedList', 'numberedList', 'outdent', 'indent', '|',
                'blockQuote', 'insertTable', 'mediaEmbed', '|',
                'alignment', 'undo', 'redo', '|',
                'imageUpload'
            ]
        },
        simpleUpload: {
            uploadUrl: '{{ url("admin/berita/upload_gambar") }}', 
            withCredentials: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
            }
        }
    }).then(editor => {
        ck = editor;
    }).catch(console.error);

    function isEmptyHtml(html) {
        if (!html) return true;
        const text = html.replace(/&nbsp;/g, ' ').replace(/<br\s*\/?>/gi, ' ').replace(/<[^>]*>/g, ' ').trim();
        return text.length === 0;
    }

    document.querySelector('form[action*="admin/berita/store"], form[action*="admin/berita/update"]')
        ?.addEventListener('submit', function(e) {
            try {
                const data = ck.getData();
                if (isEmptyHtml(data)) {
                    e.preventDefault();
                    alert('Isi berita wajib diisi.');
                    ck.editing.view.focus();
                    return false;
                }
                document.getElementById('isi_berita').value = data;
            } catch (err) {
                console.warn(err);
            }
        });
}

document.addEventListener('DOMContentLoaded', () => {
    const setupLivePreview = (pos) => {
        const contentInput = document.getElementById(`${pos}_content`);
        const directionInput = document.getElementById(`${pos}_direction`);
        const speedInput = document.getElementById(`${pos}_speed`);
        const marquee = document.getElementById(`preview_marquee_${pos}`);

        if (!contentInput || !marquee) return;

        // Live update text
        contentInput.addEventListener('input', (e) => {
            marquee.innerText = e.target.value || 'Preview teks akan muncul di sini...';
        });

        // Live update direction
        directionInput.addEventListener('change', (e) => {
            marquee.setAttribute('direction', e.target.value);
        });

        // Live update speed
        speedInput.addEventListener('input', (e) => {
            marquee.setAttribute('scrollamount', e.target.value || '5');
        });
    };

    setupLivePreview('top');
    setupLivePreview('bottom');
});