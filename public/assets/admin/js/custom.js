// assets/admin/js/custom.js

/* =========================================================
   CUSTOM SCRIPT: DATATABLES + PENCARIAN BERITA
   ========================================================= */

(function ($) {
  $(function () {
    var $tables = $('table.display');
    var $searchBeritaInput = $('#searchBeritaInput');

    // Table ada? plugin ada? sudah pernah init?
    if (!$tables.length) {
      // no-op: halaman ini tidak punya tabel display
    } else if (typeof $.fn.DataTable !== 'function') {
      console.warn('DataTables belum termuat. Cek urutan <script>.');
    } else {
      $tables.each(function () {
        var $table = $(this);

        if ($.fn.DataTable.isDataTable($table)) {
          return;
        }

        var dataTable = $table.DataTable({
          pageLength: 10,
          lengthChange: false,
          ordering: true,
          autoWidth: false,
          scrollX: true,
          order: [[0, 'asc']],
          language: {
            emptyTable: "Belum ada data.",
            zeroRecords: "Belum ada data yang cocok.",
            info: "Menampilkan _START_–_END_ dari _TOTAL_ entri",
            infoEmpty: "Menampilkan 0 entri",
            infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
            search: "Cari:",
            paginate: { first: "Pertama", previous: "Sebelumnya", next: "Berikutnya", last: "Terakhir" },
            lengthMenu: "Tampilkan _MENU_ entri",
            processing: "Memproses..."
          }
        });

        if ($searchBeritaInput.length && $table.is('#basic-datatables')) {
          $table.closest('.dataTables_wrapper').find('.dataTables_filter').hide();

          $searchBeritaInput.on('input', function () {
            dataTable.search(this.value).draw();
          });
        }
      });
    }
  });
})(jQuery);

/* =========================================================
   CUSTOM SCRIPT: IMAGE UPLOAD PREVIEW (JANGKAUAN LAYANAN)
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {
  // Tangkap semua input file yang memiliki class spesifik ini
  const fileInputs = document.querySelectorAll('.coverage-file-input');

  fileInputs.forEach(function (input) {
    input.addEventListener('change', function () {
      // Ambil ID tujuan preview dari attribute data-preview
      const targetPreviewId = this.getAttribute('data-preview');
      const previewElement = document.getElementById(targetPreviewId);

      // Cek apakah ada file yang dipilih
      if (this.files && this.files[0]) {
        const reader = new FileReader();

        reader.onload = function (event) {
          // Masukkan base64 image ke source img
          previewElement.src = event.target.result;
          // Tampilkan element img
          previewElement.classList.remove('d-none');
        };

        // Mulai membaca file
        reader.readAsDataURL(this.files[0]);
      } else {
        // Jika user batal memilih file (Cancel)
        previewElement.src = '';
        previewElement.classList.add('d-none');
      }
    });
  });
});

/* =========================================================
   CUSTOM SCRIPT: LIVE SEARCH PENGUMUMAN
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('searchPengumumanForm');
  const input = document.getElementById('searchPengumumanInput');

  if (!form || !input) {
    return;
  }

  let timeoutId;

  input.addEventListener('input', function () {
    clearTimeout(timeoutId);

    timeoutId = setTimeout(function () {
      form.submit();
    }, 350);
  });
});

/* =========================================================
   CUSTOM SCRIPT: REPEATER FIELD PENGATURAN FOOTER
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {
  const linksWrap = document.getElementById('linksRepeater');
  const linkTpl = document.getElementById('linkTemplate');
  const addLink = document.getElementById('btnAddLink');

  if (addLink && linksWrap && linkTpl) {
    addLink.addEventListener('click', function () {
      linksWrap.appendChild(linkTpl.content.cloneNode(true));
    });

    linksWrap.addEventListener('click', function (e) {
      if (e.target.closest('.btnRemoveLink')) {
        e.target.closest('.link-item')?.remove();
      }
    });
  }

  const socialWrap = document.getElementById('socialRepeater');
  const socialTpl = document.getElementById('socialTemplate');
  const addSocial = document.getElementById('btnAddSocial');

  if (addSocial && socialWrap && socialTpl) {
    addSocial.addEventListener('click', function () {
      socialWrap.appendChild(socialTpl.content.cloneNode(true));
    });

    socialWrap.addEventListener('click', function (e) {
      if (e.target.closest('.btnRemoveSocial')) {
        e.target.closest('.social-item')?.remove();
      }
    });
  }
});

/* =========================================================
   CUSTOM SCRIPT: SWEETALERT KONFIRMASI HAPUS
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {
  const deleteForms = document.querySelectorAll('.js-delete-form');

  if (!deleteForms.length || typeof swal === 'undefined') {
    return;
  }

  deleteForms.forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const title = form.dataset.deleteTitle || 'Konfirmasi Hapus';
      const text = form.dataset.deleteText || 'Data ini akan dihapus secara permanen.';

      swal({
        title: title,
        text: text,
        icon: 'warning',
        buttons: {
          cancel: {
            text: 'Batal',
            visible: true,
            className: 'btn btn-warning'
          },
          confirm: {
            text: 'Ya, Hapus',
            visible: true,
            className: 'btn btn-danger'
          }
        }
      }).then(function (willDelete) {
        if (willDelete) {
          form.submit();
        }
      });
    });
  });
});

/* =========================================================
   CUSTOM SCRIPT: CKEDITOR BERITA + VALIDASI ISI
   ========================================================= */

let textareaBerita = document.querySelector('#isi_berita');

if (textareaBerita && typeof ClassicEditor !== 'undefined') {
  let ck;
  const uploadUrl = textareaBerita.dataset.uploadUrl;
  const csrfToken =
    document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
    document.querySelector('input[name="_token"]')?.value ||
    '';

  const editorConfig = {
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
    }
  };

  if (uploadUrl) {
    editorConfig.simpleUpload = {
      uploadUrl: uploadUrl,
      withCredentials: false,
      headers: {
        'X-CSRF-TOKEN': csrfToken
      }
    };
  }

  ClassicEditor.create(textareaBerita, editorConfig).then(editor => {
    ck = editor;
  }).catch(console.error);

  function isEmptyHtml(html) {
    if (!html) return true;
    const text = html.replace(/&nbsp;/g, ' ').replace(/<br\s*\/?>/gi, ' ').replace(/<[^>]*>/g, ' ').trim();
    return text.length === 0;
  }

  textareaBerita.closest('form')?.addEventListener('submit', function (e) {
    try {
      const data = ck.getData();
      if (isEmptyHtml(data)) {
        e.preventDefault();
        alert('Isi berita wajib diisi.');
        ck.editing.view.focus();
        return false;
      }
      textareaBerita.value = data;
    } catch (err) {
      console.warn(err);
    }
  });
}

/* =========================================================
    CUSTOM SCRIPT: IS_ACTIVE RUNNING TEXT CHECKBOX
    =========================================================
*/
// Tambahkan logika untuk merespon perubahan checkbox secara langsung
document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
  checkbox.addEventListener('change', function () {
    const position = this.name.includes('top') ? 'top' : 'bottom';
    const marquee = document.getElementById(`preview_marquee_${position}`);

    if (this.checked) {
      marquee.style.opacity = "1";
      marquee.style.filter = "grayscale(0%)";
    } else {
      marquee.style.opacity = "0.3";
      marquee.style.filter = "grayscale(100%)";
    }
  });
});

// Jalankan saat pertama kali load
window.addEventListener('load', function () {
  document.querySelectorAll('input[type="checkbox"]').forEach(c => c.dispatchEvent(new Event('change')));
});

/* =========================================================
   CUSTOM SCRIPT: LIVE PREVIEW RUNNING TEXT
   ========================================================= */

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

/* =========================================================
   CUSTOM SCRIPT: CHART DASHBOARD
   ========================================================= */

window.addEventListener('load', function () {
  if (typeof Chart === 'undefined') {
    return;
  }

  const elCov = document.getElementById('coverageChart');
  if (elCov) {
    new Chart(elCov, {
      type: 'bar',
      data: {
        labels: ['Jumlah KK', 'Penduduk', 'RW', 'RT'],
        datasets: [{
          label: 'Jumlah',
          data: [7884, 25724, 12, 48],
          backgroundColor: '#1147a7'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  }

  const elSurat = document.getElementById('suratChart');
  if (elSurat) {
    new Chart(elSurat, {
      type: 'bar',
      data: {
        labels: ['Nov', 'Des', 'Jan', 'Feb', 'Mar', 'Apr'],
        datasets: [{
          label: 'Pengajuan',
          data: [50, 80, 45, 90, 110, 60],
          backgroundColor: '#ffc107'
        }]
      },
      options: {
        responsive: true
      }
    });
  }
});
