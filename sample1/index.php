<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<style>
:root {
  --navy:        #0f172a;
  --navy-mid:    #1e293b;
  --navy-light:  #334155;
  --gold:        #f0a500;
  --gold-light:  #fbbf24;
  --emerald:     #10b981;
  --rose:        #f43f5e;
  --sky:         #38bdf8;
  --indigo:      #6366f1;
  --surface:     #f8fafc;
  --card-bg:     #ffffff;
  --border:      #e2e8f0;
  --text-main:   #0f172a;
  --text-muted:  #64748b;
  --sidebar-w:   260px;
  --topbar-h:    64px;
  --radius:      14px;
  --shadow:      0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
  --shadow-lg:   0 8px 40px rgba(0,0,0,.12);
  --transition:  all .25s cubic-bezier(.4,0,.2,1);
}

*, *::before, *::after { box-sizing: border-box; margin:0; padding:0; }

body {
  font-family: 'DM Sans', sans-serif;
  background: var(--surface);
  color: var(--text-main);
  overflow-x: hidden;
}

/* ───────── SIDEBAR ───────── */
.sidebar {
  position: fixed;
  top: 0; left: 0;
  width: var(--sidebar-w);
  height: 100vh;
  background: var(--navy);
  display: flex;
  flex-direction: column;
  z-index: 1000;
  overflow-y: auto;
  transition: var(--transition);
}
.sidebar::-webkit-scrollbar { width: 4px; }
.sidebar::-webkit-scrollbar-thumb { background: var(--navy-light); border-radius: 4px; }

.sidebar-brand {
  padding: 22px 24px 18px;
  border-bottom: 1px solid rgba(255,255,255,.07);
}
.brand-logo {
  display: flex;
  align-items: center;
  gap: 10px;
}
.brand-icon {
  width: 38px; height: 38px;
  background: linear-gradient(135deg, var(--gold), #e68a00);
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px; color: white; font-weight: 700;
  flex-shrink: 0;
}
.brand-name {
  font-family: 'Playfair Display', serif;
  font-size: 1.3rem;
  color: #fff;
  font-weight: 600;
  letter-spacing: .3px;
}
.brand-sub { font-size: .7rem; color: rgba(255,255,255,.4); letter-spacing: .5px; text-transform: uppercase; }

.sidebar-user {
  margin: 16px;
  padding: 14px 16px;
  background: rgba(255,255,255,.06);
  border-radius: 12px;
  display: flex;
  align-items: center;
  gap: 12px;
}
.user-avatar {
  width: 40px; height: 40px;
  background: linear-gradient(135deg, var(--indigo), var(--sky));
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 15px; color: white; font-weight: 600;
  flex-shrink: 0;
}
.user-name { font-size: .85rem; color: #fff; font-weight: 600; }
.user-role { font-size: .72rem; color: var(--gold-light); }

.nav-section-label {
  font-size: .67rem;
  letter-spacing: 1.2px;
  text-transform: uppercase;
  color: rgba(255,255,255,.3);
  padding: 16px 24px 6px;
}
.nav-item-link {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 11px 24px;
  color: rgba(255,255,255,.6);
  text-decoration: none;
  font-size: .88rem;
  font-weight: 500;
  border-left: 3px solid transparent;
  transition: var(--transition);
  cursor: pointer;
  border-left-color: transparent;
}
.nav-item-link:hover { color: #fff; background: rgba(255,255,255,.05); }
.nav-item-link.active {
  color: var(--gold-light);
  background: rgba(240,165,0,.1);
  border-left-color: var(--gold);
}
.nav-item-link i { width: 18px; text-align: center; font-size: .9rem; }

/* ───────── TOPBAR ───────── */
.topbar {
  position: fixed;
  top: 0;
  left: var(--sidebar-w);
  right: 0;
  height: var(--topbar-h);
  background: var(--card-bg);
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 28px;
  z-index: 900;
  transition: var(--transition);
}
.topbar-left { display: flex; align-items: center; gap: 14px; }
.topbar-right { display: flex; align-items: center; gap: 10px; }
.hamburger-btn {
  background: none; border: none;
  width: 36px; height: 36px;
  display: flex; align-items: center; justify-content: center;
  border-radius: 8px; cursor: pointer; color: var(--text-muted);
  font-size: 1.1rem; transition: var(--transition);
}
.hamburger-btn:hover { background: var(--surface); color: var(--text-main); }
.page-title { font-size: 1rem; font-weight: 600; }
.topbar-badge {
  width: 34px; height: 34px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; position: relative;
  font-size: .9rem; transition: var(--transition);
  color: var(--text-muted); background: var(--surface);
  border: 1px solid var(--border);
}
.topbar-badge:hover { background: var(--navy); color: #fff; border-color: var(--navy); }
.notif-dot {
  position: absolute; top: 5px; right: 5px;
  width: 7px; height: 7px;
  background: var(--rose); border-radius: 50%;
  border: 1.5px solid white;
}
.topbar-avatar {
  width: 34px; height: 34px;
  background: linear-gradient(135deg, var(--gold), #e68a00);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 13px; font-weight: 700; color: white; cursor: pointer;
}
.breadcrumb-bar {
  font-size: .78rem;
  color: var(--text-muted);
  display: flex; align-items: center; gap: 5px;
}
.breadcrumb-bar span { color: var(--text-main); font-weight: 500; }

/* ───────── MAIN CONTENT ───────── */
.main-content {
  margin-left: var(--sidebar-w);
  padding-top: var(--topbar-h);
  min-height: 100vh;
  transition: var(--transition);
}
.page-wrapper { padding: 28px; }

/* ───────── STATS CARDS ───────── */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 18px;
  margin-bottom: 26px;
}
@media(max-width:1200px){ .stats-grid { grid-template-columns: repeat(2,1fr); } }
@media(max-width:640px){ .stats-grid { grid-template-columns: 1fr; } }

.stat-card {
  background: var(--card-bg);
  border-radius: var(--radius);
  padding: 20px 22px;
  box-shadow: var(--shadow);
  border: 1px solid var(--border);
  display: flex;
  align-items: center;
  gap: 16px;
  transition: var(--transition);
  overflow: hidden;
  position: relative;
}
.stat-card::after {
  content: '';
  position: absolute;
  top: -30px; right: -30px;
  width: 90px; height: 90px;
  border-radius: 50%;
  opacity: .06;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }
.stat-card.gold::after  { background: var(--gold); }
.stat-card.emerald::after { background: var(--emerald); }
.stat-card.rose::after  { background: var(--rose); }
.stat-card.indigo::after { background: var(--indigo); }

.stat-icon {
  width: 48px; height: 48px;
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.15rem; flex-shrink: 0;
}
.stat-icon.gold   { background: rgba(240,165,0,.12); color: var(--gold); }
.stat-icon.emerald{ background: rgba(16,185,129,.12); color: var(--emerald); }
.stat-icon.rose   { background: rgba(244,63,94,.12); color: var(--rose); }
.stat-icon.indigo { background: rgba(99,102,241,.12); color: var(--indigo); }

.stat-val { font-size: 1.6rem; font-weight: 700; line-height: 1; }
.stat-label { font-size: .78rem; color: var(--text-muted); margin-top: 3px; }
.stat-change { font-size: .73rem; font-weight: 600; margin-top: 4px; display: flex; align-items: center; gap: 3px; }
.stat-change.up   { color: var(--emerald); }
.stat-change.down { color: var(--rose); }

/* ───────── SECTION TABS ───────── */
.section-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 18px;
  gap: 12px;
}
.section-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.25rem;
  font-weight: 600;
}
.section-title span { color: var(--gold); }

.main-tabs {
  display: flex;
  gap: 4px;
  background: var(--surface);
  border: 1px solid var(--border);
  padding: 5px;
  border-radius: 12px;
  margin-bottom: 24px;
  overflow-x: auto;
}
.main-tabs::-webkit-scrollbar { display: none; }
.main-tab-btn {
  display: flex;
  align-items: center;
  gap: 7px;
  padding: 10px 18px;
  border: none;
  border-radius: 8px;
  background: transparent;
  font-family: 'DM Sans', sans-serif;
  font-size: .85rem;
  font-weight: 500;
  color: var(--text-muted);
  cursor: pointer;
  white-space: nowrap;
  transition: var(--transition);
}
.main-tab-btn:hover { color: var(--text-main); background: rgba(0,0,0,.04); }
.main-tab-btn.active {
  background: var(--card-bg);
  color: var(--text-main);
  font-weight: 600;
  box-shadow: 0 1px 4px rgba(0,0,0,.1);
}
.main-tab-btn.active.t-personal i { color: var(--emerald); }
.main-tab-btn.active.t-task i     { color: var(--gold); }
.main-tab-btn.active.t-assigned i { color: var(--indigo); }
.main-tab-btn.active.t-meeting i  { color: var(--rose); }
.main-tab-btn.active.t-report i   { color: var(--sky); }
.main-tab-btn.active.t-faculty i  { color: var(--text-muted); }
.tab-count {
  font-size: .68rem;
  padding: 1px 6px;
  border-radius: 20px;
  background: var(--navy);
  color: #fff;
  font-weight: 700;
}

/* ───────── CARD BASE ───────── */
.panel-card {
  background: var(--card-bg);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  border: 1px solid var(--border);
  overflow: hidden;
}
.panel-card .card-head {
  padding: 18px 22px 16px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}
.panel-card .card-head h6 {
  font-size: .92rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
}
.panel-card .card-head h6 i { color: var(--gold); }
.panel-card .card-body-inner { padding: 20px 22px; }

/* ───────── PERSONAL TODO ───────── */
.todo-input-row {
  display: flex;
  gap: 10px;
  margin-bottom: 18px;
}
.todo-input-row input {
  flex: 1;
  border: 1.5px solid var(--border);
  border-radius: 10px;
  padding: 10px 14px;
  font-family: 'DM Sans', sans-serif;
  font-size: .88rem;
  outline: none;
  transition: var(--transition);
}
.todo-input-row input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(240,165,0,.1); }
.btn-add-todo {
  background: var(--gold);
  color: white;
  border: none;
  border-radius: 10px;
  padding: 10px 18px;
  font-family: 'DM Sans', sans-serif;
  font-size: .85rem;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 7px;
  transition: var(--transition);
}
.btn-add-todo:hover { background: #e68a00; transform: translateY(-1px); }

.todo-list { display: flex; flex-direction: column; gap: 8px; }
.todo-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 14px;
  background: var(--surface);
  border-radius: 10px;
  border: 1px solid var(--border);
  transition: var(--transition);
  animation: slideIn .25s ease;
}
@keyframes slideIn { from { opacity:0; transform: translateX(-10px); } to { opacity:1; transform: translateX(0); } }
.todo-item:hover { border-color: var(--gold); background: rgba(240,165,0,.03); }
.todo-item.done { opacity: .55; }
.todo-item.done .todo-text { text-decoration: line-through; color: var(--text-muted); }
.todo-checkbox {
  width: 18px; height: 18px;
  border-radius: 5px;
  border: 2px solid var(--border);
  cursor: pointer;
  flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  transition: var(--transition);
}
.todo-checkbox.checked { background: var(--emerald); border-color: var(--emerald); color: white; font-size: 10px; }
.todo-text { flex: 1; font-size: .88rem; }
.todo-priority {
  font-size: .68rem;
  padding: 2px 8px;
  border-radius: 20px;
  font-weight: 600;
}
.p-high   { background: rgba(244,63,94,.1); color: var(--rose); }
.p-medium { background: rgba(240,165,0,.1); color: var(--gold); }
.p-low    { background: rgba(16,185,129,.1); color: var(--emerald); }
.todo-del-btn {
  background: none; border: none; cursor: pointer;
  color: var(--text-muted); padding: 4px; border-radius: 6px;
  transition: var(--transition); font-size: .85rem;
}
.todo-del-btn:hover { color: var(--rose); background: rgba(244,63,94,.08); }

/* ───────── TASK CARDS ───────── */
.task-filters {
  display: flex;
  gap: 8px;
  margin-bottom: 16px;
  flex-wrap: wrap;
}
.filter-pill {
  padding: 5px 14px;
  border-radius: 20px;
  border: 1.5px solid var(--border);
  background: var(--card-bg);
  font-size: .78rem;
  font-weight: 500;
  cursor: pointer;
  transition: var(--transition);
  color: var(--text-muted);
}
.filter-pill.active, .filter-pill:hover {
  border-color: var(--gold);
  background: rgba(240,165,0,.08);
  color: var(--gold);
}

.task-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 14px;
}
.task-card {
  background: var(--card-bg);
  border-radius: 12px;
  padding: 16px;
  border: 1px solid var(--border);
  border-top-width: 3px;
  transition: var(--transition);
  position: relative;
}
.task-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); }
.task-card.status-pending    { border-top-color: var(--gold); }
.task-card.status-inprogress { border-top-color: var(--sky); }
.task-card.status-done       { border-top-color: var(--emerald); }
.task-card.status-overdue    { border-top-color: var(--rose); }

.task-title { font-size: .9rem; font-weight: 600; margin-bottom: 6px; }
.task-desc  { font-size: .8rem; color: var(--text-muted); margin-bottom: 12px; line-height: 1.5; }
.task-meta  { display: flex; align-items: center; justify-content: space-between; gap: 8px; flex-wrap: wrap; }
.task-assignee {
  display: flex; align-items: center; gap: 6px;
  font-size: .78rem; color: var(--text-muted);
}
.mini-avatar {
  width: 22px; height: 22px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--indigo), var(--sky));
  display: flex; align-items: center; justify-content: center;
  font-size: .62rem; color: white; font-weight: 600; flex-shrink: 0;
}
.task-due   { font-size: .73rem; color: var(--text-muted); display: flex; align-items: center; gap: 4px; }
.task-due i { font-size: .7rem; }
.status-badge {
  font-size: .68rem;
  padding: 2px 9px;
  border-radius: 20px;
  font-weight: 600;
}
.sb-pending    { background: rgba(240,165,0,.1);   color: var(--gold); }
.sb-inprogress { background: rgba(56,189,248,.1);  color: var(--sky); }
.sb-done       { background: rgba(16,185,129,.1);  color: var(--emerald); }
.sb-overdue    { background: rgba(244,63,94,.1);   color: var(--rose); }

/* ───────── MEETING LAYOUT ───────── */
.meeting-actions {
  display: flex;
  gap: 10px;
  margin-bottom: 22px;
  flex-wrap: wrap;
}
.btn-primary-custom {
  background: var(--navy);
  color: white;
  border: none;
  border-radius: 10px;
  padding: 10px 18px;
  font-family: 'DM Sans', sans-serif;
  font-size: .85rem;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 7px;
  transition: var(--transition);
}
.btn-primary-custom:hover { background: var(--navy-mid); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(15,23,42,.2); }
.btn-gold {
  background: linear-gradient(135deg, var(--gold), #e68a00);
  color: white;
  border: none;
  border-radius: 10px;
  padding: 10px 18px;
  font-family: 'DM Sans', sans-serif;
  font-size: .85rem;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 7px;
  transition: var(--transition);
}
.btn-gold:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(240,165,0,.3); }

.meeting-sub-tabs {
  display: flex;
  gap: 0;
  margin-bottom: 20px;
  border-bottom: 2px solid var(--border);
}
.m-tab-btn {
  padding: 10px 20px;
  border: none;
  background: transparent;
  font-family: 'DM Sans', sans-serif;
  font-size: .85rem;
  font-weight: 500;
  color: var(--text-muted);
  cursor: pointer;
  border-bottom: 2px solid transparent;
  margin-bottom: -2px;
  transition: var(--transition);
}
.m-tab-btn:hover { color: var(--text-main); }
.m-tab-btn.active { color: var(--rose); border-bottom-color: var(--rose); font-weight: 600; }

/* ───────── MEETING TABLE / CALENDAR ───────── */
.meeting-calendar-row {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 18px;
  margin-bottom: 20px;
}
@media(max-width:900px){ .meeting-calendar-row { grid-template-columns: 1fr; } }

.mini-calendar {
  background: var(--card-bg);
  border-radius: var(--radius);
  border: 1px solid var(--border);
  padding: 18px;
  box-shadow: var(--shadow);
}
.cal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 14px;
}
.cal-nav-btn {
  background: none; border: none; cursor: pointer;
  width: 28px; height: 28px;
  display: flex; align-items: center; justify-content: center;
  border-radius: 7px;
  color: var(--text-muted);
  transition: var(--transition);
}
.cal-nav-btn:hover { background: var(--surface); color: var(--text-main); }
.cal-month { font-weight: 600; font-size: .9rem; }
.cal-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 3px;
}
.cal-day-name { text-align: center; font-size: .68rem; font-weight: 600; color: var(--text-muted); padding: 4px 0; }
.cal-day {
  text-align: center;
  font-size: .8rem;
  padding: 6px 0;
  border-radius: 7px;
  cursor: pointer;
  transition: var(--transition);
  position: relative;
}
.cal-day:hover { background: var(--surface); }
.cal-day.today { background: var(--navy); color: white; font-weight: 700; }
.cal-day.has-event::after {
  content: '';
  position: absolute; bottom: 3px; left: 50%; transform: translateX(-50%);
  width: 4px; height: 4px;
  border-radius: 50%;
  background: var(--gold);
}
.cal-day.has-event.today::after { background: var(--gold-light); }
.cal-day.other-month { opacity: .35; }
.cal-day.selected { background: rgba(240,165,0,.15); color: var(--gold); font-weight: 700; border: 1.5px solid rgba(240,165,0,.3); }

.upcoming-list { display: flex; flex-direction: column; gap: 0; }
.upcoming-item {
  display: flex;
  gap: 12px;
  padding: 12px 0;
  border-bottom: 1px solid var(--border);
}
.upcoming-item:last-child { border-bottom: none; }
.upcoming-date-block {
  flex-shrink: 0;
  width: 42px;
  text-align: center;
  background: var(--surface);
  border-radius: 9px;
  padding: 6px 0;
  border: 1px solid var(--border);
}
.upcoming-day { font-size: 1.1rem; font-weight: 700; line-height: 1; color: var(--navy); }
.upcoming-mon { font-size: .62rem; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); }
.upcoming-info .ui-title { font-size: .85rem; font-weight: 600; margin-bottom: 2px; }
.upcoming-info .ui-meta { font-size: .75rem; color: var(--text-muted); display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.dot-sep { width: 3px; height: 3px; border-radius: 50%; background: var(--border); }
.meeting-type-dot {
  width: 8px; height: 8px;
  border-radius: 50%;
  display: inline-block;
  margin-right: 4px;
}

/* ───────── ENHANCED DATA TABLE ───────── */
.dt-wrapper {
  overflow-x: auto;
  border-radius: var(--radius);
}
table.styled-table {
  width: 100% !important;
  border-collapse: separate !important;
  border-spacing: 0;
  font-size: .85rem;
}
table.styled-table thead tr {
  background: var(--navy) !important;
}
table.styled-table thead th {
  background: transparent !important;
  color: rgba(255,255,255,.85) !important;
  font-weight: 600 !important;
  padding: 13px 14px !important;
  border: none !important;
  text-align: left !important;
  white-space: nowrap;
  font-size: .78rem;
  letter-spacing: .3px;
  text-transform: uppercase;
}
table.styled-table thead th:first-child { border-top-left-radius: 10px; }
table.styled-table thead th:last-child  { border-top-right-radius: 10px; }
table.styled-table tbody tr { transition: var(--transition); }
table.styled-table tbody tr:nth-child(even) { background: rgba(248,250,252,.8); }
table.styled-table tbody tr:hover { background: rgba(240,165,0,.04) !important; }
table.styled-table td {
  padding: 11px 14px !important;
  border-bottom: 1px solid var(--border) !important;
  vertical-align: middle !important;
}

/* ───────── BADGES ───────── */
.badge-status {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 3px 10px;
  border-radius: 20px;
  font-size: .72rem;
  font-weight: 600;
}
.badge-status.pending  { background: rgba(240,165,0,.1); color: var(--gold); }
.badge-status.approved { background: rgba(16,185,129,.1); color: var(--emerald); }
.badge-status.rejected { background: rgba(244,63,94,.1); color: var(--rose); }

/* ───────── ACTION BUTTONS ───────── */
.btn-sm-action {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 5px 12px;
  border-radius: 7px;
  border: none;
  font-family: 'DM Sans', sans-serif;
  font-size: .75rem;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}
.btn-sm-action:hover { transform: translateY(-1px); }
.btn-notify  { background: rgba(99,102,241,.1);  color: var(--indigo); }
.btn-notify:hover  { background: var(--indigo); color: white; }
.btn-approve { background: rgba(16,185,129,.1);  color: var(--emerald); }
.btn-approve:hover { background: var(--emerald); color: white; }
.btn-reject  { background: rgba(244,63,94,.1);   color: var(--rose); }
.btn-reject:hover  { background: var(--rose); color: white; }
.btn-delete  { background: rgba(244,63,94,.1);   color: var(--rose); }
.btn-delete:hover  { background: var(--rose); color: white; }
.btn-cancel  { background: rgba(100,116,139,.1); color: var(--text-muted); }
.btn-cancel:hover  { background: var(--text-muted); color: white; }

/* ───────── TIME SLOT SELECTOR ───────── */
.time-slot-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-top: 12px;
}
.ts-chip {
  padding: 6px 14px;
  border-radius: 8px;
  font-size: .8rem;
  font-weight: 500;
  cursor: pointer;
  transition: var(--transition);
  border: 1.5px solid transparent;
}
.ts-chip.available { background: rgba(16,185,129,.1); border-color: rgba(16,185,129,.2); color: var(--emerald); }
.ts-chip.available:hover { background: var(--emerald); color: white; }
.ts-chip.booked    { background: rgba(244,63,94,.07); border-color: rgba(244,63,94,.15); color: var(--rose); cursor: not-allowed; opacity: .7; }
.ts-chip.selected  { background: var(--navy); color: white; border-color: var(--navy); }

/* ───────── MODAL ───────── */
.modal-content {
  border: none;
  border-radius: 16px;
  box-shadow: 0 20px 60px rgba(0,0,0,.2);
}
.modal-header-custom {
  background: var(--navy);
  color: white;
  padding: 20px 24px;
  border-radius: 16px 16px 0 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.modal-header-custom h5 { font-size: 1rem; font-weight: 600; margin: 0; }
.modal-close-btn {
  background: rgba(255,255,255,.1); border: none;
  width: 32px; height: 32px;
  border-radius: 8px;
  color: white; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: var(--transition);
}
.modal-close-btn:hover { background: rgba(255,255,255,.2); }
.modal-body { padding: 24px; }
.modal-footer { padding: 14px 24px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }

.form-label-custom { font-size: .82rem; font-weight: 600; color: var(--navy); margin-bottom: 6px; display: block; }
.form-input-custom {
  width: 100%;
  border: 1.5px solid var(--border);
  border-radius: 10px;
  padding: 9px 13px;
  font-family: 'DM Sans', sans-serif;
  font-size: .88rem;
  outline: none;
  transition: var(--transition);
}
.form-input-custom:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(240,165,0,.1); }
.form-select-custom {
  width: 100%;<li class="nav-item" role="presentation">
                        <a class="nav-link" id="c" data-bs-toggle="tab" href="#taskhis" role="tab"
                            aria-controls="taskhis-tab" aria-selected="false">
                            <span class="hidden-xs-down" style="font-size: 0.9em;font-family: 'Poppins', 'Open Sans', sans-serif;
font-weight: 600;color:grey;">
                                <i class="fas fa-chart-line tab-icon"></i> View Task History
                            </span>
                        </a>
                    </li>
  border: 1.5px solid var(--border);
  border-radius: 10px;
  padding: 9px 13px;
  font-family: 'DM Sans', sans-serif;
  font-size: .88rem;
  outline: none;
  appearance: none;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 12px;
  transition: var(--transition);
  cursor: pointer;
}
.form-select-custom:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(240,165,0,.1); }
.mb-form { margin-bottom: 14px; }

/* ───────── FACULTY VIEW ───────── */
.faculty-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 14px;
}
.faculty-card {
  background: var(--card-bg);
  border-radius: var(--radius);
  padding: 18px;
  border: 1px solid var(--border);
  text-align: center;
  transition: var(--transition);
  position: relative;
}
.faculty-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); }
.faculty-avatar-lg {
  width: 56px; height: 56px;
  border-radius: 50%;
  margin: 0 auto 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.3rem; font-weight: 700; color: white;
}
.faculty-name  { font-size: .88rem; font-weight: 600; margin-bottom: 2px; }
.faculty-dept  { font-size: .75rem; color: var(--text-muted); margin-bottom: 10px; }
.faculty-stats { display: flex; justify-content: center; gap: 16px; }
.fac-stat { text-align: center; }
.fac-stat-val   { font-size: 1rem; font-weight: 700; }
.fac-stat-label { font-size: .65rem; color: var(--text-muted); }
.faculty-progress {
  margin-top: 12px;
  height: 5px;
  background: var(--border);
  border-radius: 5px;
  overflow: hidden;
}
.faculty-progress-bar {
  height: 100%;
  border-radius: 5px;
  background: linear-gradient(90deg, var(--gold), var(--emerald));
  transition: width .6s ease;
}
.online-dot {
  position: absolute;
  top: 14px; right: 14px;
  width: 9px; height: 9px;
  border-radius: 50%;
  border: 2px solid white;
}
.online-dot.online   { background: var(--emerald); }
.online-dot.offline  { background: var(--text-muted); }
.online-dot.away     { background: var(--gold); }

/* ───────── REPORT SECTION ───────── */
.report-widgets {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 18px;
  margin-bottom: 20px;
}
@media(max-width:900px){ .report-widgets { grid-template-columns: 1fr 1fr; } }
@media(max-width:600px){ .report-widgets { grid-template-columns: 1fr; } }

.report-widget {
  background: var(--card-bg);
  border-radius: var(--radius);
  padding: 20px;
  border: 1px solid var(--border);
  box-shadow: var(--shadow);
}
.rw-title  { font-size: .82rem; font-weight: 600; color: var(--text-muted); margin-bottom: 14px; text-transform: uppercase; letter-spacing: .5px; }
.rw-big    { font-size: 2rem; font-weight: 700; line-height: 1; }
.rw-sub    { font-size: .75rem; color: var(--text-muted); margin-top: 4px; }
.donut-wrap { display: flex; align-items: center; gap: 14px; margin-top: 6px; }
.donut-legend { display: flex; flex-direction: column; gap: 6px; flex: 1; }
.dl-item  { display: flex; align-items: center; gap: 6px; font-size: .75rem; }
.dl-dot   { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
.dl-label { flex: 1; color: var(--text-muted); }
.dl-val   { font-weight: 600; }

/* ───────── LOADER ───────── */
.page-loader {
  position: fixed;
  inset: 0;
  background: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  transition: opacity .4s ease;
}
.loader-ring {
  width: 46px; height: 46px;
  border: 4px solid var(--border);
  border-top-color: var(--gold);
  border-right-color: var(--navy);
  border-radius: 50%;
  animation: spin .8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
.loader-text { font-size: .8rem; color: var(--text-muted); margin-top: 14px; letter-spacing: .5px; }

/* ───────── RESPONSIVE ───────── */
@media(max-width:768px){
  .sidebar { transform: translateX(-100%); }
  .sidebar.open { transform: translateX(0); }
  .main-content, .topbar { margin-left: 0; left: 0; }
  .page-wrapper { padding: 16px; }
  .stats-grid { grid-template-columns: repeat(2,1fr); }
}

/* Tab panes */
.tab-pane { display: none; }
.tab-pane.active { display: block; animation: fadeUp .3s ease; }
@keyframes fadeUp { from { opacity:0; transform: translateY(8px); } to { opacity:1; transform: translateY(0); } }
.m-tab-pane { display: none; }
.m-tab-pane.active { display: block; }

/* Empty state */
.empty-state {
  text-align: center;
  padding: 50px 20px;
  color: var(--text-muted);
}
.empty-state i { font-size: 2.5rem; opacity: .3; margin-bottom: 10px; }
.empty-state p { font-size: .88rem; }
</style>
</head>
<body>

<!-- Page Loader -->
<div class="page-loader" id="pageLoader">
  <div class="loader-ring"></div>
  <p class="loader-text">Loading Dashboard…</p>
</div>

<!-- ───────── SIDEBAR ───────── -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <div class="brand-logo">
      <div class="brand-icon">M</div>
      <div>
        <div class="brand-name">MIC Portal</div>
        <div class="brand-sub">MKCE Management</div>
      </div>
    </div>
  </div>

  <div class="sidebar-user">
    <div class="user-avatar">BS</div>
    <div>
      <div class="user-name">Dr. B.S. Murugan</div>
      <div class="user-role">Principal</div>
    </div>
  </div>

  <div class="nav-section-label">Navigation</div>
  <a class="nav-item-link active" onclick="switchMainTab('personal'); highlightNav(this)">
    <i class="fas fa-list-check"></i> Personal ToDo
  </a>
  <a class="nav-item-link" onclick="switchMainTab('task'); highlightNav(this)">
    <i class="fas fa-user-tag"></i> My Task
  </a>
  <a class="nav-item-link" onclick="switchMainTab('assigned'); highlightNav(this)">
    <i class="fas fa-tasks"></i> Assigned Task
  </a>
  <a class="nav-item-link" onclick="switchMainTab('meeting'); highlightNav(this)">
    <i class="fas fa-handshake"></i> Meeting
  </a>
  <a class="nav-item-link" onclick="switchMainTab('report'); highlightNav(this)">
    <i class="fas fa-chart-line"></i> Report & Analysis
  </a>
  <a class="nav-item-link" onclick="switchMainTab('faculty'); highlightNav(this)">
    <i class="fas fa-chalkboard-teacher"></i> Faculty View
  </a>

  <div class="nav-section-label" style="margin-top:auto; padding-top:24px;">System</div>
  <a class="nav-item-link"><i class="fas fa-cog"></i> Settings</a>
  <a class="nav-item-link" style="margin-bottom:20px;"><i class="fas fa-sign-out-alt"></i> Logout</a>
</aside>

<!-- ───────── TOPBAR ───────── -->
<header class="topbar">
  <div class="topbar-left">
    <button class="hamburger-btn" id="hamburger"><i class="fas fa-bars"></i></button>
    <div>
      <div class="page-title" id="pageTitle">Personal ToDo</div>
      <div class="breadcrumb-bar">Dashboard <i class="fas fa-chevron-right" style="font-size:.6rem"></i> <span id="breadcrumbCurrent">Personal ToDo</span></div>
    </div>
  </div>
  <div class="topbar-right">
    <div class="topbar-badge" title="Notifications">
      <i class="fas fa-bell"></i>
      <div class="notif-dot"></div>
    </div>
    <div class="topbar-badge" title="Calendar"><i class="fas fa-calendar-alt"></i></div>
    <div class="topbar-avatar" title="Profile">BS</div>
  </div>
</header>

<!-- ───────── MAIN CONTENT ───────── -->
<main class="main-content">
  <div class="page-wrapper">

    <!-- Stats Row -->
    <div class="stats-grid">
      <div class="stat-card gold">
        <div class="stat-icon gold"><i class="fas fa-list-check"></i></div>
        <div>
          <div class="stat-val">12</div>
          <div class="stat-label">Personal Tasks</div>
          <div class="stat-change up"><i class="fas fa-arrow-up"></i> 4 new today</div>
        </div>
      </div>
      <div class="stat-card emerald">
        <div class="stat-icon emerald"><i class="fas fa-check-circle"></i></div>
        <div>
          <div class="stat-val">8</div>
          <div class="stat-label">Completed Tasks</div>
          <div class="stat-change up"><i class="fas fa-arrow-up"></i> 2 this week</div>
        </div>
      </div>
      <div class="stat-card rose">
        <div class="stat-icon rose"><i class="fas fa-handshake"></i></div>
        <div>
          <div class="stat-val">5</div>
          <div class="stat-label">Meetings Today</div>
          <div class="stat-change down"><i class="fas fa-arrow-down"></i> 1 cancelled</div>
        </div>
      </div>
      <div class="stat-card indigo">
        <div class="stat-icon indigo"><i class="fas fa-chalkboard-teacher"></i></div>
        <div>
          <div class="stat-val">64</div>
          <div class="stat-label">Active Faculty</div>
          <div class="stat-change up"><i class="fas fa-arrow-up"></i> 3 on leave</div>
        </div>
      </div>
    </div>

    <!-- Main Tabs -->
    <div class="main-tabs" id="mainTabs">
      <button class="main-tab-btn t-personal active" onclick="switchMainTab('personal')">
        <i class="fas fa-list-check"></i> Personal ToDo <span class="tab-count">12</span>
      </button>
      <button class="main-tab-btn t-task" onclick="switchMainTab('task')">
        <i class="fas fa-user-tag"></i> My Task <span class="tab-count">7</span>
      </button>
      <button class="main-tab-btn t-assigned" onclick="switchMainTab('assigned')">
        <i class="fas fa-tasks"></i> Assigned Task <span class="tab-count">9</span>
      </button>
      <button class="main-tab-btn t-meeting" onclick="switchMainTab('meeting')">
        <i class="fas fa-handshake"></i> Meeting <span class="tab-count">5</span>
      </button>
      <button class="main-tab-btn t-report" onclick="switchMainTab('report')">
        <i class="fas fa-chart-line"></i> Report &amp; Analysis
      </button>
      <button class="main-tab-btn t-faculty" onclick="switchMainTab('faculty')">
        <i class="fas fa-chalkboard-teacher"></i> Faculty View
      </button>
    </div>

    <!-- ═══════ PERSONAL TODO ═══════ -->
    <div class="tab-pane active" id="pane-personal">
      <div class="section-header">
        <div class="section-title">Personal <span>To-Do</span> List</div>
        <div style="font-size:.78rem; color:var(--text-muted)">Wed, 26 Feb 2026</div>
      </div>
      <div class="panel-card">
        <div class="card-head">
          <h6><i class="fas fa-plus-circle"></i> Add New Task</h6>
          <div style="display:flex; gap:6px;">
            <select class="form-select-custom" id="todoFilter" style="width:120px; font-size:.78rem; padding:5px 10px;">
              <option value="all">All</option>
              <option value="pending">Pending</option>
              <option value="done">Done</option>
            </select>
          </div>
        </div>
        <div class="card-body-inner">
          <div class="todo-input-row">
            <input type="text" id="todoInput" placeholder="Type a new task…" />
            <select class="form-select-custom" id="todoPriority" style="width:120px;">
              <option value="high">🔴 High</option>
              <option value="medium" selected>🟡 Medium</option>
              <option value="low">🟢 Low</option>
            </select>
            <button class="btn-add-todo" onclick="addTodo()"><i class="fas fa-plus"></i> Add</button>
          </div>
          <div class="todo-list" id="todoList">
            <!-- Items injected by JS -->
          </div>
        </div>
      </div>
    </div>

    <!-- ═══════ MY TASK ═══════ -->
    <div class="tab-pane" id="pane-task">
      <div class="section-header">
        <div class="section-title">My <span>Tasks</span></div>
        <button class="btn-gold" style="padding:8px 14px; font-size:.8rem;"><i class="fas fa-plus"></i> New Task</button>
      </div>
      <div class="task-filters">
        <div class="filter-pill active">All</div>
        <div class="filter-pill">Pending</div>
        <div class="filter-pill">In Progress</div>
        <div class="filter-pill">Completed</div>
        <div class="filter-pill">Overdue</div>
      </div>
      <div class="task-grid" id="myTaskGrid"></div>
    </div>

    <!-- ═══════ ASSIGNED TASK ═══════ -->
    <div class="tab-pane" id="pane-assigned">
      <div class="section-header">
        <div class="section-title">Assigned <span>Tasks</span></div>
        <button class="btn-gold" style="padding:8px 14px; font-size:.8rem;"><i class="fas fa-user-plus"></i> Assign Task</button>
      </div>
      <div class="panel-card">
        <div class="card-head"><h6><i class="fas fa-tasks"></i> Task Assignments</h6></div>
        <div class="card-body-inner" style="padding:0;">
          <div class="dt-wrapper" style="padding:16px 22px;">
            <table class="styled-table" id="assignedTable">
              <thead>
                <tr>
                  <th>Task</th>
                  <th>Assigned To</th>
                  <th>Department</th>
                  <th>Due Date</th>
                  <th>Priority</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="assignedTbody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- ═══════ MEETING ═══════ -->
    <div class="tab-pane" id="pane-meeting">
      <div class="section-header">
        <div class="section-title">Meeting <span>Scheduler</span></div>
      </div>

      <div class="meeting-actions">
        <button class="btn-primary-custom" onclick="openMeetingModal()">
          <i class="fas fa-calendar-plus"></i> Schedule Meeting
        </button>
        <button class="btn-gold" onclick="openChairmanModal()">
          <i class="fas fa-user-tie"></i> Request Chairman Meeting
        </button>
      </div>

      <div class="meeting-calendar-row">
        <div class="panel-card">
          <div class="card-head"><h6><i class="fas fa-calendar-alt"></i> Meeting Overview</h6></div>
          <div style="padding:0 2px;">
            <div class="meeting-sub-tabs" style="padding:0 20px;">
              <button class="m-tab-btn active" onclick="switchMeetTab('scheduled', this)">Scheduled</button>
              <button class="m-tab-btn" onclick="switchMeetTab('approve', this)">Approve / Reject</button>
              <button class="m-tab-btn" onclick="switchMeetTab('requested', this)">Requested</button>
              <button class="m-tab-btn" onclick="switchMeetTab('mgmt', this)">Management</button>
            </div>
            <div style="padding:0 20px 20px;">
              <div class="m-tab-pane active" id="mpane-scheduled">
                <table class="styled-table" id="scheduledTable">
                  <thead><tr><th>Title</th><th>Date</th><th>Time</th><th>Venue</th><th>Participants</th><th>Action</th></tr></thead>
                  <tbody id="scheduledTbody"></tbody>
                </table>
              </div>
              <div class="m-tab-pane" id="mpane-approve">
                <table class="styled-table" id="approveTable">
                  <thead><tr><th>Purpose</th><th>Date</th><th>Time</th><th>Requested By</th><th>Status</th><th>Action</th></tr></thead>
                  <tbody id="approveTbody"></tbody>
                </table>
              </div>
              <div class="m-tab-pane" id="mpane-requested">
                <table class="styled-table" id="reqTable">
                  <thead><tr><th>Purpose</th><th>Date</th><th>Time</th><th>Requested To</th><th>Status</th><th>Action</th></tr></thead>
                  <tbody id="reqTbody"></tbody>
                </table>
              </div>
              <div class="m-tab-pane" id="mpane-mgmt">
                <table class="styled-table" id="mgmtTable">
                  <thead><tr><th>Title</th><th>Agenda</th><th>Date</th><th>Time</th><th>Venue</th><th>Assigned By</th></tr></thead>
                  <tbody id="mgmtTbody"></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Mini Calendar + Upcoming -->
        <div style="display:flex; flex-direction:column; gap:18px;">
          <div class="mini-calendar">
            <div class="cal-header">
              <button class="cal-nav-btn" onclick="changeMonth(-1)"><i class="fas fa-chevron-left"></i></button>
              <span class="cal-month" id="calMonthLabel"></span>
              <button class="cal-nav-btn" onclick="changeMonth(1)"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="cal-grid" id="calGrid"></div>
          </div>
          <div class="panel-card" style="flex:1;">
            <div class="card-head"><h6><i class="fas fa-clock"></i> Upcoming Meetings</h6></div>
            <div class="card-body-inner" style="padding:14px 18px;">
              <div class="upcoming-list" id="upcomingList"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ═══════ REPORT ═══════ -->
    <div class="tab-pane" id="pane-report">
      <div class="section-header">
        <div class="section-title">Report &amp; <span>Analysis</span></div>
        <button class="btn-primary-custom" style="padding:8px 14px; font-size:.8rem;"><i class="fas fa-download"></i> Export</button>
      </div>
      <div class="report-widgets">
        <div class="report-widget">
          <div class="rw-title">Task Completion Rate</div>
          <div class="rw-big" style="color:var(--emerald)">78%</div>
          <div class="rw-sub">This month • ↑ 6% vs last month</div>
          <div style="margin-top:14px; height:6px; background:var(--border); border-radius:6px; overflow:hidden;">
            <div style="width:78%; height:100%; background:linear-gradient(90deg,var(--emerald),var(--sky)); border-radius:6px;"></div>
          </div>
        </div>
        <div class="report-widget">
          <div class="rw-title">Meetings This Month</div>
          <div class="rw-big" style="color:var(--rose)">23</div>
          <div class="rw-sub">18 completed • 5 upcoming</div>
          <div class="donut-wrap" style="margin-top:10px;">
            <svg width="56" height="56" viewBox="0 0 36 36">
              <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e2e8f0" stroke-width="3.8"/>
              <circle cx="18" cy="18" r="15.9" fill="none" stroke="var(--rose)" stroke-width="3.8"
                stroke-dasharray="78 100" stroke-dashoffset="25" stroke-linecap="round"/>
            </svg>
            <div class="donut-legend">
              <div class="dl-item"><div class="dl-dot" style="background:var(--rose)"></div><div class="dl-label">Completed</div><div class="dl-val">18</div></div>
              <div class="dl-item"><div class="dl-dot" style="background:var(--gold)"></div><div class="dl-label">Upcoming</div><div class="dl-val">5</div></div>
            </div>
          </div>
        </div>
        <div class="report-widget">
          <div class="rw-title">Faculty Task Submissions</div>
          <div class="rw-big" style="color:var(--indigo)">91%</div>
          <div class="rw-sub">61 of 67 submitted on time</div>
          <div style="margin-top:14px; display:flex; flex-direction:column; gap:6px;">
            <div style="display:flex; justify-content:space-between; font-size:.75rem;"><span>On Time</span><span style="font-weight:600; color:var(--emerald)">61</span></div>
            <div style="height:4px; background:var(--border); border-radius:4px; overflow:hidden;"><div style="width:91%; height:100%; background:var(--emerald); border-radius:4px;"></div></div>
            <div style="display:flex; justify-content:space-between; font-size:.75rem;"><span>Late</span><span style="font-weight:600; color:var(--rose)">6</span></div>
            <div style="height:4px; background:var(--border); border-radius:4px; overflow:hidden;"><div style="width:9%; height:100%; background:var(--rose); border-radius:4px;"></div></div>
          </div>
        </div>
      </div>
      <div class="panel-card">
        <div class="card-head"><h6><i class="fas fa-table"></i> Detailed Task Report</h6></div>
        <div class="card-body-inner" style="padding:0 22px 20px;">
          <table class="styled-table" id="reportTable">
            <thead><tr><th>Faculty Name</th><th>Dept</th><th>Total Tasks</th><th>Completed</th><th>Pending</th><th>Overdue</th><th>Rate</th></tr></thead>
            <tbody id="reportTbody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ═══════ FACULTY VIEW ═══════ -->
    <div class="tab-pane" id="pane-faculty">
      <div class="section-header">
        <div class="section-title">Faculty <span>Overview</span></div>
        <div style="display:flex;gap:8px; align-items:center;">
          <input type="text" placeholder="Search faculty…" style="border:1.5px solid var(--border); border-radius:9px; padding:7px 12px; font-size:.82rem; outline:none; font-family:'DM Sans',sans-serif;">
          <select class="form-select-custom" style="width:140px; font-size:.8rem; padding:7px 12px;">
            <option>All Departments</option>
            <option>CSE</option><option>ECE</option><option>MECH</option><option>CIVIL</option>
          </select>
        </div>
      </div>
      <div class="faculty-grid" id="facultyGrid"></div>
    </div>

  </div><!-- /page-wrapper -->
</main>

<!-- ═══════ ADD MEETING MODAL ═══════ -->
<div class="modal fade" id="addMeetingModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header-custom">
        <h5><i class="fas fa-calendar-plus" style="margin-right:8px;color:var(--gold-light)"></i>Schedule Staff Meeting</h5>
        <button class="modal-close-btn" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-12"><div class="mb-form"><label class="form-label-custom">Meeting Title</label><input type="text" class="form-input-custom" placeholder="Enter meeting title…"></div></div>
          <div class="col-12"><div class="mb-form"><label class="form-label-custom">Agenda</label><textarea class="form-input-custom" rows="3" placeholder="Describe the agenda…"></textarea></div></div>
          <div class="col-md-6"><div class="mb-form"><label class="form-label-custom">Participant Type</label>
            <select class="form-select-custom" id="modalParticipantType" onchange="toggleParticipantFields()">
              <option value="">— Select Type —</option>
              <option value="hod">HOD</option>
              <option value="portfolio">Portfolio</option>
              <option value="faculty">Faculty</option>
            </select>
          </div></div>
          <div class="col-md-6 d-none" id="deptFieldWrap"><div class="mb-form"><label class="form-label-custom">Department</label><select class="form-select-custom"><option>— Select Department —</option><option>CSE</option><option>ECE</option><option>MECH</option><option>CIVIL</option></select></div></div>
          <div class="col-md-6"><div class="mb-form"><label class="form-label-custom">Date &amp; Time</label><input type="datetime-local" class="form-input-custom"></div></div>
          <div class="col-md-6"><div class="mb-form"><label class="form-label-custom">End Time</label><input type="time" class="form-input-custom"></div></div>
          <div class="col-md-6"><div class="mb-form"><label class="form-label-custom">Mode</label><select class="form-select-custom"><option>Online</option><option>Offline</option></select></div></div>
          <div class="col-md-6"><div class="mb-form"><label class="form-label-custom">Location / Link</label><input type="text" class="form-input-custom" placeholder="Zoom link or room number…"></div></div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn-cancel btn-sm-action" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
        <button class="btn-sm-action btn-approve" style="padding:9px 20px; font-size:.85rem;"><i class="fas fa-check"></i> Schedule Meeting</button>
      </div>
    </div>
  </div>
</div>

<!-- ═══════ CHAIRMAN REQUEST MODAL ═══════ -->
<div class="modal fade" id="chairmanModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header-custom">
        <h5><i class="fas fa-user-tie" style="margin-right:8px;color:var(--gold-light)"></i>Request Chairman Meeting</h5>
        <button class="modal-close-btn" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body">
        <div class="mb-form"><label class="form-label-custom">Purpose</label><textarea class="form-input-custom" rows="3" placeholder="State the purpose of the meeting…"></textarea></div>
        <div class="mb-form"><label class="form-label-custom">Preferred Date</label>
          <div style="display:flex; gap:10px;">
            <input type="date" class="form-input-custom" id="chairDateInput">
            <button class="btn-primary-custom" style="padding:9px 14px; white-space:nowrap; font-size:.82rem;" onclick="loadTimeSlots()"><i class="fas fa-search"></i> View Slots</button>
          </div>
        </div>
        <div id="slotsSection" style="display:none;">
          <label class="form-label-custom">Available Time Slots</label>
          <div class="time-slot-grid" id="slotsGrid"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn-cancel btn-sm-action" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
        <button class="btn-sm-action btn-approve" style="padding:9px 20px; font-size:.85rem;"><i class="fas fa-paper-plane"></i> Send Request</button>
      </div>
    </div>
  </div>
</div>

<script>
// ═══════ PAGE LOAD ═══════
window.addEventListener('load', () => {
  setTimeout(() => {
    document.getElementById('pageLoader').style.opacity = '0';
    setTimeout(() => document.getElementById('pageLoader').style.display = 'none', 400);
  }, 700);
  renderCalendar();
  renderTodos();
  renderTasks();
  renderAssigned();
  renderMeetings();
  renderFaculty();
  renderReport();
  renderUpcoming();
});

// ═══════ SIDEBAR TOGGLE ═══════
document.getElementById('hamburger').addEventListener('click', () => {
  document.getElementById('sidebar').classList.toggle('open');
});

function highlightNav(el) {
  document.querySelectorAll('.nav-item-link').forEach(n => n.classList.remove('active'));
  el.classList.add('active');
}

// ═══════ TAB SWITCHING ═══════
const tabTitles = {
  personal: 'Personal ToDo', task: 'My Tasks', assigned: 'Assigned Tasks',
  meeting: 'Meeting Scheduler', report: 'Report & Analysis', faculty: 'Faculty Overview'
};
function switchMainTab(name) {
  document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
  document.getElementById('pane-' + name).classList.add('active');
  document.querySelectorAll('.main-tab-btn').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.main-tab-btn').forEach(b => {
    if (b.textContent.toLowerCase().includes(name === 'faculty' ? 'faculty' : name.substring(0,5))) b.classList.add('active');
  });
  document.getElementById('pageTitle').textContent = tabTitles[name];
  document.getElementById('breadcrumbCurrent').textContent = tabTitles[name];
}

function switchMeetTab(name, btn) {
  document.querySelectorAll('.m-tab-pane').forEach(p => p.classList.remove('active'));
  document.getElementById('mpane-' + name).classList.add('active');
  document.querySelectorAll('.m-tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}

// ═══════ MODAL HELPERS ═══════
function openMeetingModal() { new bootstrap.Modal(document.getElementById('addMeetingModal')).show(); }
function openChairmanModal() { new bootstrap.Modal(document.getElementById('chairmanModal')).show(); }
function toggleParticipantFields() {
  const v = document.getElementById('modalParticipantType').value;
  document.getElementById('deptFieldWrap').classList.toggle('d-none', v !== 'faculty');
}

// ═══════ CALENDAR ═══════
let calDate = new Date();
const meetingDates = [3, 8, 12, 15, 20, 25];
function renderCalendar() {
  const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
  const days = ['Su','Mo','Tu','We','Th','Fr','Sa'];
  document.getElementById('calMonthLabel').textContent = `${months[calDate.getMonth()]} ${calDate.getFullYear()}`;
  const grid = document.getElementById('calGrid');
  grid.innerHTML = days.map(d => `<div class="cal-day-name">${d}</div>`).join('');
  const first = new Date(calDate.getFullYear(), calDate.getMonth(), 1).getDay();
  const daysInMonth = new Date(calDate.getFullYear(), calDate.getMonth()+1, 0).getDate();
  const today = new Date();
  for (let i = 0; i < first; i++) {
    const prevDay = new Date(calDate.getFullYear(), calDate.getMonth(), -first + i + 1).getDate();
    grid.innerHTML += `<div class="cal-day other-month">${prevDay}</div>`;
  }
  for (let d = 1; d <= daysInMonth; d++) {
    const isToday = d === today.getDate() && calDate.getMonth() === today.getMonth() && calDate.getFullYear() === today.getFullYear();
    const hasEvent = meetingDates.includes(d);
    grid.innerHTML += `<div class="cal-day${isToday?' today':''}${hasEvent?' has-event':''}">${d}</div>`;
  }
}
function changeMonth(dir) { calDate.setMonth(calDate.getMonth() + dir); renderCalendar(); }

// ═══════ UPCOMING ═══════
const upcomingData = [
  { day:26, mon:'Feb', title:'Staff Briefing', time:'10:00 AM', venue:'Conf. Room A', type:'staff' },
  { day:27, mon:'Feb', title:'HOD Review',    time:'2:30 PM',  venue:'Principal Office', type:'hod' },
  { day:1,  mon:'Mar', title:'Board Meeting', time:'9:00 AM',  venue:'Board Hall', type:'board' },
];
const typeColors = { staff:'var(--indigo)', hod:'var(--gold)', board:'var(--rose)' };
function renderUpcoming() {
  document.getElementById('upcomingList').innerHTML = upcomingData.map(u => `
    <div class="upcoming-item">
      <div class="upcoming-date-block"><div class="upcoming-day">${u.day}</div><div class="upcoming-mon">${u.mon}</div></div>
      <div class="upcoming-info">
        <div class="ui-title">
          <span class="meeting-type-dot" style="background:${typeColors[u.type]}"></span>${u.title}
        </div>
        <div class="ui-meta"><span>${u.time}</span><div class="dot-sep"></div><span>${u.venue}</span></div>
      </div>
    </div>`).join('');
}

// ═══════ TIME SLOTS ═══════
function loadTimeSlots() {
  const slots = [
    { start:'9:00', end:'9:30', available:true },
    { start:'9:30', end:'10:00', available:false },
    { start:'10:00', end:'10:30', available:true },
    { start:'11:00', end:'11:30', available:true },
    { start:'2:00', end:'2:30', available:false },
    { start:'3:00', end:'3:30', available:true },
  ];
  const grid = document.getElementById('slotsGrid');
  grid.innerHTML = slots.map(s => `
    <div class="ts-chip ${s.available?'available':'booked'}" ${s.available?`onclick="selectSlot(this,'${s.start}-${s.end}')`:''}>${s.start} – ${s.end}</div>
  `).join('');
  document.getElementById('slotsSection').style.display = 'block';
}
function selectSlot(el, val) {
  document.querySelectorAll('.ts-chip').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
}

// ═══════ TODOS ═══════
let todos = [
  { id:1, text:'Review faculty appraisals',  priority:'high',   done:false },
  { id:2, text:'Sign leave applications',     priority:'medium', done:false },
  { id:3, text:'Prepare NAAC documentation',  priority:'high',   done:true  },
  { id:4, text:'Check lab utilization report',priority:'low',    done:false },
  { id:5, text:'Reply to Board email',         priority:'medium', done:false },
];
let todoId = 6;
function addTodo() {
  const text = document.getElementById('todoInput').value.trim();
  const priority = document.getElementById('todoPriority').value;
  if (!text) return;
  todos.unshift({ id: todoId++, text, priority, done: false });
  document.getElementById('todoInput').value = '';
  renderTodos();
}
function toggleTodo(id) {
  const t = todos.find(t => t.id === id);
  if (t) { t.done = !t.done; renderTodos(); }
}
function deleteTodo(id) {
  todos = todos.filter(t => t.id !== id); renderTodos();
}
function renderTodos() {
  const filter = document.getElementById('todoFilter')?.value || 'all';
  const filtered = todos.filter(t => filter === 'all' || (filter === 'done' ? t.done : !t.done));
  const priorityLabel = { high:'High', medium:'Medium', low:'Low' };
  const priorityClass = { high:'p-high', medium:'p-medium', low:'p-low' };
  document.getElementById('todoList').innerHTML = filtered.length === 0
    ? `<div class="empty-state"><i class="fas fa-check-circle"></i><p>No tasks here!</p></div>`
    : filtered.map(t => `
    <div class="todo-item ${t.done?'done':''}">
      <div class="todo-checkbox ${t.done?'checked':''}" onclick="toggleTodo(${t.id})">
        ${t.done?'<i class="fas fa-check"></i>':''}
      </div>
      <span class="todo-text">${t.text}</span>
      <span class="todo-priority ${priorityClass[t.priority]}">${priorityLabel[t.priority]}</span>
      <button class="todo-del-btn" onclick="deleteTodo(${t.id})"><i class="fas fa-trash-alt"></i></button>
    </div>`).join('');
}
document.addEventListener('keydown', e => {
  if (e.key === 'Enter' && document.activeElement.id === 'todoInput') addTodo();
});

// ═══════ TASKS ═══════
const tasksData = [
  { title:'NAAC Criterion II',   desc:'Compile teaching-learning data for NAAC self-study report.', status:'inprogress', due:'28 Feb', assignee:null, priority:'High' },
  { title:'Budget Allocation',   desc:'Finalize department-wise annual budget for FY 2026-27.',       status:'pending',    due:'5 Mar',  assignee:null, priority:'High' },
  { title:'Lab Audit Report',    desc:'Review and submit lab utilization audit to management.',       status:'pending',    due:'2 Mar',  assignee:null, priority:'Medium' },
  { title:'Faculty Appraisal',   desc:'Complete faculty performance appraisal for all departments.',  status:'done',       due:'20 Feb', assignee:null, priority:'Low' },
  { title:'Admission Strategy',  desc:'Plan outreach and counselling for 2026 admissions.',           status:'overdue',    due:'22 Feb', assignee:null, priority:'High' },
  { title:'Curriculum Review',   desc:'Revise syllabi in line with NEP 2020 guidelines.',            status:'inprogress', due:'10 Mar', assignee:null, priority:'Medium' },
  { title:'Research Committee',  desc:'Form committee for internal research grant allocation.',       status:'pending',    due:'12 Mar', assignee:null, priority:'Low' },
];
const statusClass = { pending:'status-pending', inprogress:'status-inprogress', done:'status-done', overdue:'status-overdue' };
const sbClass = { pending:'sb-pending', inprogress:'sb-inprogress', done:'sb-done', overdue:'sb-overdue' };
const statusLabel = { pending:'Pending', inprogress:'In Progress', done:'Completed', overdue:'Overdue' };
function renderTasks() {
  document.getElementById('myTaskGrid').innerHTML = tasksData.map(t => `
    <div class="task-card ${statusClass[t.status]}">
      <div class="task-title">${t.title}</div>
      <div class="task-desc">${t.desc}</div>
      <div class="task-meta">
        <span class="status-badge ${sbClass[t.status]}">${statusLabel[t.status]}</span>
        <span class="task-due"><i class="far fa-calendar"></i> ${t.due}</span>
        <span class="todo-priority ${t.priority==='High'?'p-high':t.priority==='Medium'?'p-medium':'p-low'}" style="font-size:.68rem;padding:2px 8px;">${t.priority}</span>
      </div>
    </div>`).join('');
}

// ═══════ ASSIGNED TABLE ═══════
const assignedData = [
  { task:'Prepare IQAC report', to:'Dr. Priya', dept:'CSE', due:'1 Mar', priority:'High', status:'inprogress' },
  { task:'Sports day coordination', to:'Mr. Karthik', dept:'Physical Ed.', due:'5 Mar', priority:'Medium', status:'pending' },
  { task:'Industry visit planning', to:'Dr. Ravi', dept:'MECH', due:'8 Mar', priority:'Low', status:'pending' },
  { task:'Alumni meet logistics', to:'Ms. Deepa', dept:'ECE', due:'15 Mar', priority:'Medium', status:'done' },
  { task:'Anti-ragging committee minutes', to:'Dr. Kumar', dept:'CIVIL', due:'26 Feb', priority:'High', status:'overdue' },
];
function renderAssigned() {
  document.getElementById('assignedTbody').innerHTML = assignedData.map(r => `
    <tr>
      <td style="font-weight:500">${r.task}</td>
      <td><div style="display:flex;align-items:center;gap:8px;"><div class="mini-avatar">${r.to.split(' ')[1][0]}</div>${r.to}</div></td>
      <td>${r.dept}</td>
      <td>${r.due}</td>
      <td><span class="todo-priority ${r.priority==='High'?'p-high':r.priority==='Medium'?'p-medium':'p-low'}">${r.priority}</span></td>
      <td><span class="badge-status ${r.status==='done'?'approved':r.status==='overdue'?'rejected':'pending'}">${statusLabel[r.status]}</span></td>
      <td><div style="display:flex;gap:6px;">
        <button class="btn-sm-action btn-notify"><i class="fas fa-bell"></i></button>
        <button class="btn-sm-action btn-delete"><i class="fas fa-trash"></i></button>
      </div></td>
    </tr>`).join('');
}

// ═══════ MEETINGS ═══════
const meetingsData = [
  { title:'HOD Monthly Review', date:'26 Feb 2026', time:'10:00–11:00 AM', venue:'Board Room', staff:'All HODs' },
  { title:'Staff Welfare Meeting', date:'27 Feb 2026', time:'2:00–3:00 PM', venue:'Seminar Hall', staff:'Staff Committee' },
  { title:'NAAC Prep Committee', date:'1 Mar 2026', time:'9:30–11:00 AM', venue:'Conf. Room B', staff:'NAAC Team' },
];
const approveData = [
  { purpose:'Lab equipment budget approval', date:'26 Feb 2026', time:'3:00 PM', by:'Dr. Selvam (HOD-CSE)', status:'pending' },
  { purpose:'Faculty leave request discussion', date:'25 Feb 2026', time:'11:30 AM', by:'Mr. Arun (HOD-ECE)', status:'approved' },
  { purpose:'Student grievance redressal', date:'24 Feb 2026', time:'4:00 PM', by:'Ms. Kavitha (HOD-CIVIL)', status:'rejected' },
];
const requestedData = [
  { purpose:'Annual review discussion', date:'28 Feb 2026', time:'10:00 AM', to:'Chairman', status:'pending' },
  { purpose:'Accreditation update', date:'20 Feb 2026', time:'2:00 PM', to:'Chairman', status:'approved' },
];
const mgmtData = [
  { title:'Institutional Development Plan', agenda:'Review 5-year strategic roadmap', date:'3 Mar 2026', time:'9:00 AM', venue:'Management Block', by:'Chairman' },
  { title:'Ranking Strategy Meeting', agenda:'NIRF & QS ranking action plan', date:'10 Mar 2026', time:'10:30 AM', venue:'Management Block', by:'Secretary' },
];
function renderMeetings() {
  document.getElementById('scheduledTbody').innerHTML = meetingsData.map(m => `
    <tr>
      <td style="font-weight:600">${m.title}</td><td>${m.date}</td><td>${m.time}</td><td>${m.venue}</td><td>${m.staff}</td>
      <td><div style="display:flex;gap:6px;">
        <button class="btn-sm-action btn-notify"><i class="fas fa-bell"></i> Notify</button>
        <button class="btn-sm-action btn-delete"><i class="fas fa-trash"></i></button>
      </div></td>
    </tr>`).join('');

  document.getElementById('approveTbody').innerHTML = approveData.map(a => `
    <tr>
      <td>${a.purpose}</td><td>${a.date}</td><td>${a.time}</td><td>${a.by}</td>
      <td><span class="badge-status ${a.status}">${a.status.charAt(0).toUpperCase()+a.status.slice(1)}</span></td>
      <td><div style="display:flex;gap:6px;">
        ${a.status==='pending'?`<button class="btn-sm-action btn-approve"><i class="fas fa-check"></i> Approve</button>
        <button class="btn-sm-action btn-reject"><i class="fas fa-times"></i> Reject</button>`:'<span style="color:var(--text-muted);font-size:.78rem;">No action</span>'}
      </div></td>
    </tr>`).join('');

  document.getElementById('reqTbody').innerHTML = requestedData.map(r => `
    <tr>
      <td>${r.purpose}</td><td>${r.date}</td><td>${r.time}</td><td>${r.to}</td>
      <td><span class="badge-status ${r.status}">${r.status.charAt(0).toUpperCase()+r.status.slice(1)}</span></td>
      <td>${r.status==='pending'?`<button class="btn-sm-action btn-cancel"><i class="fas fa-trash"></i> Cancel</button>`:'<span style="color:var(--text-muted);font-size:.78rem;">—</span>'}</td>
    </tr>`).join('');

  document.getElementById('mgmtTbody').innerHTML = mgmtData.map(m => `
    <tr>
      <td style="font-weight:600">${m.title}</td><td>${m.agenda}</td><td>${m.date}</td><td>${m.time}</td><td>${m.venue}</td><td>${m.by}</td>
    </tr>`).join('');
}

// ═══════ FACULTY ═══════
const facultyColors = ['#6366f1','#10b981','#f43f5e','#f0a500','#38bdf8','#8b5cf6'];
const facultyData = [
  { name:'Dr. Priya Subramanian', dept:'CSE', tasks:8, done:7, status:'online' },
  { name:'Mr. Karthik Raja',      dept:'Phy. Ed.', tasks:3, done:2, status:'away' },
  { name:'Dr. Ravi Kumar',        dept:'MECH', tasks:6, done:5, status:'online' },
  { name:'Ms. Deepa Anand',       dept:'ECE', tasks:5, done:5, status:'offline' },
  { name:'Dr. Selvam Nair',       dept:'CSE', tasks:9, done:6, status:'online' },
  { name:'Ms. Kavitha Moorthy',   dept:'CIVIL', tasks:4, done:3, status:'away' },
  { name:'Dr. Senthil Pandi',     dept:'MECH', tasks:7, done:4, status:'online' },
  { name:'Mr. Balamurugan',       dept:'EEE', tasks:5, done:5, status:'offline' },
];
function renderFaculty() {
  document.getElementById('facultyGrid').innerHTML = facultyData.map((f, i) => {
    const initials = f.name.split(' ').slice(0,2).map(w => w[0]).join('');
    const pct = Math.round((f.done / f.tasks) * 100);
    return `
    <div class="faculty-card">
      <div class="online-dot ${f.status}"></div>
      <div class="faculty-avatar-lg" style="background:${facultyColors[i % facultyColors.length]}">${initials}</div>
      <div class="faculty-name">${f.name}</div>
      <div class="faculty-dept">${f.dept}</div>
      <div class="faculty-stats">
        <div class="fac-stat"><div class="fac-stat-val">${f.tasks}</div><div class="fac-stat-label">Tasks</div></div>
        <div class="fac-stat"><div class="fac-stat-val" style="color:var(--emerald)">${f.done}</div><div class="fac-stat-label">Done</div></div>
        <div class="fac-stat"><div class="fac-stat-val" style="color:var(--gold)">${pct}%</div><div class="fac-stat-label">Rate</div></div>
      </div>
      <div class="faculty-progress"><div class="faculty-progress-bar" style="width:${pct}%"></div></div>
    </div>`;
  }).join('');
}

// ═══════ REPORT TABLE ═══════
function renderReport() {
  document.getElementById('reportTbody').innerHTML = facultyData.map(f => {
    const pct = Math.round((f.done / f.tasks)*100);
    const overdue = f.tasks - f.done > 1 ? 1 : 0;
    return `<tr>
      <td style="font-weight:600">${f.name}</td>
      <td>${f.dept}</td><td>${f.tasks}</td>
      <td><span style="color:var(--emerald);font-weight:600">${f.done}</span></td>
      <td><span style="color:var(--gold);font-weight:600">${f.tasks-f.done-overdue}</span></td>
      <td><span style="color:var(--rose);font-weight:600">${overdue}</span></td>
      <td>
        <div style="display:flex;align-items:center;gap:8px;">
          <div style="flex:1;height:5px;background:var(--border);border-radius:5px;overflow:hidden;min-width:60px;">
            <div style="width:${pct}%;height:100%;background:${pct>=80?'var(--emerald)':pct>=50?'var(--gold)':'var(--rose)'};border-radius:5px;"></div>
          </div>
          <span style="font-size:.78rem;font-weight:700;color:${pct>=80?'var(--emerald)':pct>=50?'var(--gold)':'var(--rose)'}">${pct}%</span>
        </div>
      </td>
    </tr>`;
  }).join('');
}

// Filter pills interaction
document.querySelectorAll('.filter-pill').forEach(p => {
  p.addEventListener('click', function() {
    this.closest('.task-filters').querySelectorAll('.filter-pill').forEach(x => x.classList.remove('active'));
    this.classList.add('active');
  });
});
</script>
</body>
</html>