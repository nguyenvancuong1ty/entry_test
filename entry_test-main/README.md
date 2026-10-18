## Entrance Exam for THK Holdings Vietnam in Hanoi

Welcome to THK Holdings Vietnam in Hanoi!!
Thank you for applying to us!

## About this exam

In this exam, you implement for these following fields using a Laravel application.
There are required and optional field to implement.

If you implement optional field, we consider your extra technical skills.

We will use Laravel Sail to build this exam environment.
Laravel Sail is a Laravel library that allows you to build an environment using virtualization container software called docker just by typing a command.
For more information about Laravel Sail, please refer to [the official Laravel documentation](https://readouble.com/laravel/11.x/en/sail.html).

### Application's information

[view](document/INFORMATION.md)

### Implementation fields

[view](document/IMPLEMENTATION_FIELD.md)

### Notice

- You write some comments as optional. But if you do, please write in Japanese or English.
- The design (CSS style) is up to you. Please use SCSS as possible.
- If there is unclear stated and specification, you implement the best for you.
- We will consider for the selection process from all of your implemented contents.
- Even if you couldn't complete all items, no problem. We will consider only your implemented scope. So please submit it by deadline.

### How to submit this exam

Please compress the `entry_test` folder into a zip file and submit it via email.
To reduce data size, please delete the `entry_exam/node_modules` folder and `entry_exam/vendor` folder along with all files under them before compressing.

### Any comments (optional)

If you have any comments about this exam, please write them down here.
```text
【実装の概要と設計方針 / Implementation Summary & Architecture】

1. アーキテクチャと品質方針 (Architecture & Code Quality):
   - Controller、FormRequest、Service (HotelService, HotelImageService, BookingService)、Modelの責務を明確に分離し、保守性と拡張性に配慮した設計を行いました。
   - データベースの更新処理（作成・更新・削除）には `DB::transaction` を適用し、例外発生時にはトランザクションをロールバックするとともに、アップロードされた一時画像ファイルを安全に削除（パージ）するエラーハンドリングを徹底しました。
   - 部分一致検索における SQL ワイルドカード（`%`, `_`, `\`）のエスケープ処理（`addcslashes`）を実装し、意図しないワイルドカードインジェクションを防止しています。

2. 必須課題の実装 (Required Features):
   - ホテル新規作成: 入力バリデーション（日本語エラーメッセージ対応）および画像アップロードを実装。
   - ホテル編集機能: 仕様通りの「入力画面」➔「確認画面（一時保存画像プレビュー）」➔「完了画面」の3ステップ画面遷移を実装。
   - ホテル削除機能: 削除確認モーダル（JavaScript ポップアップ）を表示し、OK選択時のみ物理削除および関連画像ファイルの削除を実行。
   - ホテル検索機能の改修:
     - 未入力時のエラー修正: フォーム直下に赤字で「何も入力されていません」と表示。
     - 部分一致検索（LIKE 検索）への変更。
     - 都道府県セレクトボックスによる絞り込み機能の追加。

3. オプション課題の実装 (Optional Features):
   - レスポンシブ対応:
     - PC向けサイドメニューから、モバイル・タブレット画面（<= 768px）ではヘッダーナビゲーションへの切り替え、テーブルの横スクロール対応（overflow-x）、フォーム項目の1カラム折り返しを実装。
   - 宿泊予約管理機能:
     - ER図に準拠した `bookings` テーブルのマイグレーション作成（外部キー制約、CASCADE削除）。
     - 管理画面サイドメニューに「予約情報検索」リンクを追加。
     - 顧客名、顧客連絡先、チェックイン日時、チェックアウト日時での検索機能、および検索結果一覧表示（ホテル情報・作成/更新日時含む）を実装。
     - 動作確認用サンプルデータを投入する `BookingSeeder` を作成。

4. テスト (Automated Tests):
   - Feature Test（`AdminHotelTest`, `AdminBookingTest`）を計30ケース実装し、バリデーション、例外処理、ページネーション、下位互換性を含めて網羅的にテストしています。

この度は選考の機会をいただき、誠にありがとうございました。何卒よろしくお願い申し上げます。
```
