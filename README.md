# Gym Management System (健身房管理系統)

> **資料庫管理課程期末專題**

本專案實作了一套以資料庫為核心的健身房管理系統。系統整合了會員管理、課程排程、線上選課、簽到追蹤與器材租借功能。透過網頁介面進行 CRUD 操作，實踐資料庫設計、正規化與關聯操作的應用，並區分管理員與會員不同權限的操作介面。

## 專案性質

本專案為課程期末作業，開發重點在於：
* **資料庫設計**：ER Model 的規劃與實作。
* **資料完整性**：關聯式資料表設計與外鍵 (Foreign Key) 應用。
* **系統整合**：SQL 語法與 PHP 網頁系統的結合。
* **功能實作**：完整的 CRUD (新增、讀取、更新、刪除) 流程。

## 開發環境與技術

* **前端**：HTML, CSS, Bootstrap 5
* **後端**：PHP
* **資料庫**：MySQL (MariaDB)
* **開發工具**：VS Code
* **測試環境**：XAMPP / phpMyAdmin

## 專案功能說明

### 1. 會員端功能 (Member Portal)
* **課程瀏覽**：查看所有課程的詳細資訊 (時間、教練、地點)。
* **線上選課**：會員可自行報名感興趣的課程，並支援退選功能。
* **我的課程**：檢視已報名的課程清單與上課時間。
* **個人中心**：管理個人基本資料與密碼修改。
* **上課簽到**：針對已報名的課程進行出席簽到。

### 2. 課程與選課管理 (Courses & Enrollment)
* **課程維護**：管理員可新增、修改、刪除課程資料。
* **名單管理**：查看特定課程的報名學員名單。
* **選課紀錄**：系統自動維護會員與課程之間的多對多關聯紀錄。

### 3. 人員管理 (Users & Coaches)
* **會員管理**：管理員可檢視會員列表，維護會員資料。
* **教練管理**：新增與維護教練資訊，並將其指派至特定課程。

### 4. 簽到與器材管理 (Attendance & Equipment)
* **簽到追蹤**：紀錄會員參與課程的出席狀況與時間。
* **器材租借**：管理健身房器材清單及其借用時段紀錄。

## 資料庫設計

本系統採用關聯式資料庫設計，透過外鍵建立關聯並遵循正規化原則，以確保資料一致性。主要資料表如下：

| 資料表名稱 | 說明 |
| :--- | :--- |
| **Member** | 儲存會員登入與基本資料 |
| **Coach** | 儲存教練基本資料 |
| **Course** | 儲存課程資訊 (關聯教練) |
| **CourseEnrollment** | 儲存會員選課紀錄 (多對多中介表) |
| **Attendance** | 儲存上課簽到紀錄 |
| **EquipmentUsage** | 儲存器材借用紀錄 |

## 檔案結構

```text
gym_system/
├─ assets/                    # 前端靜態資源
│  └─ style_member.css        # 會員端專用樣式表
│
├─ template/                  # 共用版型
│  ├─ header.php              # 頁首與導覽列
│  └─ sidebar.php             # 後台側邊選單
│
├─ admin/                     # 管理員後台
│  ├─ dashboard.php           # 後台儀表板
│  ├─ course_list.php         # 課程列表與管理
│  ├─ course_add.php          # 新增課程
│  ├─ course_students.php     # 課程學員名單
│  ├─ member_list.php         # 會員列表管理
│  ├─ coach_list.php          # 教練列表管理
│  ├─ attendance_list.php     # 簽到紀錄管理
│  ├─ enrollment_list.php     # 選課紀錄總覽
│  └─ equipment_list.php      # 器材管理
│
├─ member/                    # 會員前台
│  ├─ courses.php             # 課程瀏覽與報名
│  ├─ my_courses.php          # 我的課程 (含退選)
│  ├─ enroll_course.php       # 處理報名邏輯
│  ├─ unenroll.php            # 處理退選邏輯
│  ├─ attendance.php          # 會員簽到介面
│  └─ profile.php             # 個人資料管理
│
├─ connect.php                # 資料庫連線設定
├─ gym_management.sql         # 資料庫匯出檔
├─ index.php                  # 系統入口
├─ login.php                  # 登入頁面
├─ logout.php                 # 登出邏輯
└─ README.md                  # 專案說明文件

## 安裝與資料庫建立

請依照以下步驟在本地端部署專案：

1. **啟動伺服器**：開啟 XAMPP，啟動 Apache 與 MySQL。
2. **建立資料庫**：進入 phpMyAdmin，建立一個新的資料庫命名為 `gym_management`。

3. **匯入資料表**：
   請匯入專案根目錄下的 `gym_management.sql` 檔案。
   此步驟將會自動建立所有關聯資料表，並寫入預設的測試資料 (會員、教練、課程)。

4. **設定連線**：
   確認 `connect.php` 中的資料庫帳號密碼設定是否正確 (預設通常為 user: `root`, password: ``)。

5. **執行專案**：
   開啟瀏覽器，輸入 `http://localhost/gym_system/` 即可開始使用。

## 作者資訊

* **姓名**：盧宜婷 Yi-Ting Lu
* **GitHub**: https://github.com/ytlu0930