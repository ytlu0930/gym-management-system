<style>
    body {
        background-color: #111;      /* 黑底 */
        color: #fff;                 /* 白字 */
    }

    /* 左側 Sidebar */
    .sidebar {
        width: 230px;
        background: #000;            /* 深黑 */
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        padding-top: 20px;
        border-right: 3px solid gold;
    }

    .sidebar a {
        display: block;
        padding: 12px 20px;
        color: #fff;                 /* 白字 */
        text-decoration: none;
        font-size: 17px;
        border-bottom: 1px solid #333;
    }

    .sidebar a:hover {
        background-color: gold;
        color: black;                /* 金底黑字 */
        font-weight: bold;
    }

    /* 右側主內容 */
    .content {
        margin-left: 230px;
        padding: 20px;
        color: #fff;                 /* 白字 */
    }

    h1, h2, h3 {
        color: gold;                 /* 標題金色 */
    }

    /* 表格黑底＋白字 */
    table {
        background: #222;
        color: #fff;
    }

    table thead tr {
        background: #000;
        color: gold;                 /* 表頭金色字 */
    }

    table tbody tr td {
        color: #fff;
    }

    /* 按鈕、標籤微調 */
    label {
        color: #fff;
    }

    input, select, textarea {
        background: #333 !important;
        color: #fff !important;
        border: 1px solid #555 !important;
    }

    input::placeholder {
        color: #bbb;
    }

    /* Bootstrap alert 黑底白字 */
    .alert {
        background: #222;
        color: #fff;
        border: 1px solid gold;
    }
</style>

