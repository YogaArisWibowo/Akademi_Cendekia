<!-- style.blade.php -->
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

/* ===== Body & Layout ===== */
body {
    background: #f4f8ff;
}

.main-content {
    margin-left: 280px;
    padding: 35px 45px;
}

/* ===== Sidebar ===== */
.sidebar {
    height: 100vh;
    width: 280px;
    background: linear-gradient(to bottom, #03132A, #1877FF);
    position: fixed;
    padding-top: 25px;
    color: #fff;
}

.sidebar a {
    color: rgba(255, 255, 255, 0.85);
    text-decoration: none;
    display: block;
    font-size: 15px;
    padding: 12px 20px;
    border-radius: 12px;
    margin: 6px 10px;
    transition: 0.25s;
}

.sidebar a i {
    margin-right: 10px;
}
.sidebar .logo {
  text-align: center;
  margin-bottom: 35px;
}

.sidebar a:hover,
.sidebar .active {
    background: rgba(255, 255, 255, 0.22);
    color: #fff;
}

/* ===== Topbar ===== */
.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
}

.topbar h2 {
    font-size: 28px;
    font-weight: 600;
}

.profile {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    cursor: pointer;
    font-size: 15px;
}

/* ===== Filter Dropdown ===== */
.filter-section {
    margin-bottom: 18px;
}

.dropdown-hari {
    padding: 9px 14px;
    border-radius: 7px;
    border: 1px solid #cfd6e3;
    font-size: 14px;
}

/* ===== Table ===== */
.table-wrapper {
    background: #fff;
    padding: 18px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.table-jadwal {
    width: 100%;
    font-size: 14px;
    border-collapse: collapse;
}

.table-jadwal thead {
    background: #C4DAF9;
    color: #000000;
}

.table-jadwal th,
.table-jadwal td {
    padding: 10px 14px;
    text-align: left;
}

.table-jadwal tbody tr:nth-child(even) {
    background: #eaf3ff;
}

.table-jadwal tbody tr:hover {
    background: #d9eaff;
    transition: .2s;
}

/* ===== Pagination ===== */
.pagination {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 10px;
}

.pagination .btn {
    background: #cfd9e7;
    border-radius: 50px;
    padding: 7px 14px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    transition: .25s;
}

.pagination .active,
.pagination .btn:hover {
    background: #0070d6;
    color: #fff;
}
</style>
