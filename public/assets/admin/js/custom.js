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
