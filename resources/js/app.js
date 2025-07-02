import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// import 'bootstrap/dist/js/bootstrap.bundle.min.js';


import 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';
import 'summernote/dist/summernote-bs5';

import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css';
import 'summernote/dist/summernote-bs5.min.css';
// import 'summernote/dist/font/summernote.woff2';


$(document).ready(function () {
    const table = $('#myTable').DataTable({
        scrollX: true,
        pagingType: 'simple_numbers',
    });
    $('#summernote').summernote({
        placeholder: 'Masukkan Deskripsi Disini',
        tabsize: 2,
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'manualRemoveUnderline']],
            ['view', ['fullscreen']]
        ],
    });
});
