### About Familyboard

 Familyboard是參考Laracast的[Build A Laravel App With TDD系列](https://laracasts.com/series/build-a-laravel-app-with-tdd/episodes/1) 
- 此項目為TDD練習，先寫測試（紅燈），撰寫程式通過測試（綠燈），重構
- 網站內容主要為創立計畫與實施計畫的任務，並可以分享給其他使用者一起分工合作
- 作為Laravel框架練習
- 使用Laravel 7.x

## 網站雲端部署（展示用）
- 部署至GOOGLE APP ENGINE 
- [網址]()

## 網站實作分為六個方面

- **AUTH** 註冊或登入
- **HOME** 首頁（計畫列表）
- **PROJECT** 個別計畫頁面
- **TASKS** 任務
- **PROFILE** 個人頁面
- **LOGOUT** 登出

## Auth
- 使用laravel/ui套件快速搭建前端的註冊與登入
- 使用session確認使用者身份
- 確認使用者是否登入
   * 已登入則直接跳轉首頁
   * 未登入則進到註冊／登入頁

### HOME
- 首頁配置
  * 管理計畫列表（新增/刪除）
  * 登出
  * 修改個人資料連結（轉至EDIT PROFILE）
- 首頁具有下列功能
  * 列出自己或被邀請參加的計畫列表
  * 創立計畫：點擊計畫內容後跳轉到個別計畫頁面
  * 刪除計畫，根據使用者身分：
    1. 使用者為計畫擁有者，則計畫框會出現DELETE刪除鈕
    2. 使用者非計畫擁有者，則計畫框不會出現DELETE刪除鈕
    3. 刪除時會確認使用者身份，非計畫擁有者時會出現403頁面
  
## PROJECT
- 計畫頁面為創建完成計畫所需任務
- 頁面從左上至右下分配為：
    1. 回計畫列表連結/計畫名稱
    2. 任務列表（見TASKS）
    3. 筆記
    4. 修改計畫（跳至修改計畫頁面）
    5. 計畫欄
    6. 紀錄（使用Laravel的Observer功能觀察計畫與任務的創立與修改）
        - 紀錄使用者-所做的事-時間
        * 當計畫創建時：ex. @ jhao has created a project: 3 hours ago
        * 當計畫修改時：ex. @ admin has updated the description of the project: 1 second ago
        * 當任務創建時：ex. @ admin has created a task 'hi' : 1 second ago
        * 當任務修改時: ex. @ jhao has updated the task 'a' : 22 hours ago
    6. 邀請加入計畫功能
        ＊ 邀請功能（只有計畫擁有者能夠邀請其他使用者加入）
        1. 使用者為計畫擁有者，則會出現Invite a member欄位
        2. 送出邀請時會確認使用者身份，非計畫擁有者時會出現403頁面
        ＊ 只能邀請已註冊的使用者
        1. 後端確認該email存在於users表中
        2. 不存在會出現錯誤訊息 ex. The invited member should have a valid familyboard account
        ＊ 使用Laravel的Queue功能將送信的工作儲存起來
        1. 使用php artisan queue:work 於之後執行送信任務
- 除了刪除計畫與邀請成員的計畫擁有者專屬權限外，被邀請成員擁有其他管理計畫的權限，其他人會出現403頁面
        
## TASKS
- 創立任務，共紀錄
  ＊ 任務內容
  ＊ 挑選開始時間（年/月/日/時/分）
  ＊ 挑選結束時間（年/月/日/時/分）
  ＊ 挑選該任務的負責人（名單為計畫擁有人與被邀請成員）
- 任務列表
  ＊ 已創建的任務內容
  ＊ 刷新頁面時，任務會根據結束時間與現在時間與完成狀況顯示
    1. 完成：completed
    2. 未完成，但未到期：Uncompleted
    3. 未完成，但已到期：Due
- 修改任務(跳至修改任務頁面）

## PROFILE

- 修改個人資料
  ＊ 修改email時確認是否已被他人使用，已使用則出現：The email has already been taken.
- 上傳大頭照
  ＊ 使用Laravel的storage

### TDD測試狀況
- 測試狀況
  ＊ 測試數量：48
  ＊ 耗時：4.11s
  ＊ 測試資料庫：
    1. phpunit.xml設定<server name="DB_CONNECTION" value="mysql_testing"/> 
    2. 於config/database.php設定測試資料庫需要之設定
    
- 測試情境
  ＊ 以整合測試為主
  ＊ 測試主要針對
    1. 認證測試
       - 未登入或註冊的人拜訪頁面時，要轉向到登入頁面
    2. 權限測試（已登入時）
       -  確認有權限與沒有權限的人做該行動的結果與預期符合
       -  例子：純登入使用者/被邀請的成員/計畫擁有者刪除計畫
          ＊ 計畫擁有者（有權限）：http狀態碼 :302，資料庫沒有該筆計畫
          ＊ 純登入使用者/被邀請的成員（無權限）：http狀態碼:403，資料庫還有該筆計畫
    3. 表單驗證
       - 若未滿足驗證要求，則出現錯誤
       - 利用assertSessionHasErrors確認
   ＊ 單元測試主要針對類與類關係
   





