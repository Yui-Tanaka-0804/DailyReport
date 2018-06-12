package com.example.eccprog.dailyreport

import android.content.Context
import android.content.SharedPreferences
import android.support.v7.app.AppCompatActivity
import android.os.Bundle
import android.support.v7.widget.Toolbar
import android.view.Menu
import android.view.MenuItem
import android.text.method.ScrollingMovementMethod
import android.widget.*
import kotlinx.android.synthetic.main.activity_writer.*


class WriterActivity() : AppCompatActivity(){

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_writer)

        val userStatus : SharedPreferences =
                getSharedPreferences("UserStatus", Context.MODE_PRIVATE)


        val teamNameSpinner: Spinner = findViewById(R.id.teamNameSpinner)  // チーム名のトグルのやつ
        val radioGroup: RadioGroup = findViewById(R.id.teamGroup)  // ラジオボタン


        val onlyButton: RadioButton = findViewById(R.id.onlyButton)

        // 具体的な処理はDB動くまでお預け

        // 日付を表示
        dateTextView.text = intent.getStringExtra("date")

        if (intent.getStringExtra("num") != ""){
            // 編集画面なら本文、作成者をもらう
            // チーム名 … チーム名を読み込んでどちらかのラジオボタンにチェックを入れる(ここ無理かも)
        } else {
            // 新規画面なら作成者欄にユーザー名を表示
            writerTextView.text = userStatus.getString("username", "error")
            // チーム名 … 個人のほうにチェック入れてスピナーはオフ
            onlyButton.isChecked = true
            teamNameSpinner.isClickable = false
        }



        // ラジオボタンがチームを指しているときはスピナー(チーム名一覧)を有効化
        radioGroup.setOnCheckedChangeListener { _, checkedId ->
            val selectedRadioButton: RadioButton = findViewById(checkedId) // 選択中のラジオボタン
            if (selectedRadioButton == findViewById(R.id.teamButton)) {
                teamNameSpinner.isClickable = true
//                this.teamName = writerTextView.text.toString()
            } else if (selectedRadioButton == findViewById(R.id.onlyButton)) {
                teamNameSpinner.isClickable = false
//                this.teamName = teamNameSpinner.selectedItem.toString()
            }
        }

        val textView: TextView = findViewById(R.id.editText)
        textView.movementMethod = ScrollingMovementMethod.getInstance()

        // メニューバー追加
        val myToolbar: Toolbar = findViewById(R.id.toolbar_writer)
        setSupportActionBar(myToolbar)
    }

    // menu作成時に呼び出される
    override fun onCreateOptionsMenu(menu: Menu?): Boolean {
        // ここでボタン追加するよ！！！
        menuInflater.inflate(R.menu.menu_writer, menu)
        return super.onCreateOptionsMenu(menu)
    }

    /**
     * メニューバーのボタンを追加
     */
    override fun onOptionsItemSelected(item: MenuItem): Boolean = when (item.itemId) {
    // 送信ボタン
        R.id.send -> {
            Toast.makeText(this, "この後の処理は未実装です", Toast.LENGTH_LONG).show();
            // return文は必要ない
            finish()
            true
        }
        else -> {
            // ユーザさんが予想外のことをしたよ！
            // パパに何とかしてもらうよ！
            super.onOptionsItemSelected(item)
        }
    }

}