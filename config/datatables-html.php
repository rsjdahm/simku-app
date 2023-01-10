<?php

return [
    /*
     * DataTables JavaScript global namespace.
     */

    'namespace' => 'LaravelDataTables',

    /*
     * Default table attributes when generating the table.
     */
    'table' => [
        'id'    => 'dataTableBuilder',
        // 'class' => 'table table-sm table-bordered table-hover dt-responsive display datatable',
        // 'class' => 'table table-sm table-hover dt-responsive display datatable',
        'class' => 'table table-sm table-striped table-bordered table-hover dt-responsive display datatable',
        'width' => '100%',
        'cellspacing' => '0',
    ],

    /*
     * Html builder script template.
     */
    'script' => 'datatables::script',

    /*
     * Html builder script template for DataTables Editor integration.
     */
    'editor' => 'datatables::editor',
];
