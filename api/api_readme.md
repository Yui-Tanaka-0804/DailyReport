# Nippou API

 各APIの使い方

パラメータはすべてPOSTで送信する

#### /api/isLogin.php

---

ログインの可否を取得

| parameter | value |
|---|---|
| id | ユーザID |
| password | パスワード |

##### 戻り値

文字列で返される

| value | detail |
|---|---|
| "true" | ログイン可能 |
| "false" | ログイン不可 |

#### /api/register.php

---

ユーザーを作成する

| parameter | value |
|---|---|
| id | ユーザID |
| name | 名前 |
| password | パスワード |

##### 戻り値

文字列で返される

| value | detail |
|---|---|
| "true" | 成功 |
| "false" | 失敗 |

#### /api/getReport.php

---

日報を取得

| parameter | value |
|---|---|
| id | ユーザID |
| password | パスワード |
| num | レポート番号 |

##### 戻り値

JSON形式で返される

```
{
	"id" : 作成者ID,
	"team" : チーム名,
	"main" : レポート内容,
	"date" : 作成日時,
	"latest": 更新日時
}
```

#### /api/getReportList.php

---

指定した日の日報一覧を取得

| parameter | value |
|---|---|
| id | ユーザID |
| password | パスワード |
| date | 日付 |

##### 戻り値

JSON形式で返される

```
[
	{ "num" : 日報番号,
		"userId" : 作成者ID,
		"teamName" : チーム名
	},
	...	
]
```

#### /api/getReportNum.php

---

指定した月の日報の数を取得

| parameter | value |
|---|---|
| id | ユーザID |
| password | パスワード |
| date | 日付 |

##### 戻り値

JSON形式で返される

```
[
	 1日の日報数,
	 2日の日報数,
	 ...,
	...
	 最終日の日報数
]
```

#### /api/newReport.php

---

レポートを作成する

| parameter | value |
|---|---|
| id | ユーザID |
| password | パスワード |
| team | チーム名 |
| main | 日報内容 |

##### 戻り値

作成されたレポートの番号.

失敗した場合 -1

#### /api/rewriteReport.php

---

レポートを更新する

| parameter | value |
|---|---|
| id | ユーザID |
| password | パスワード |
| num | 日報番号 |
| main | 日報内容 |

##### 戻り値

文字列で返される

| value | detail |
|---|---|
| "true" | 成功 |
| "false" | 失敗 |

#### /api/deleteReport.php

---

レポートを削除する

| parameter | value |
|---|---|
| id | ユーザID |
| password | パスワード |
| num | 日報番号 |

##### 戻り値

文字列で返される

| value | detail |
|---|---|
| "true" | 成功 |
| "false" | 失敗 |

