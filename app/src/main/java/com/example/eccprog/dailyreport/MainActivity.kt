package com.example.eccprog.dailyreport

import android.support.v7.app.AppCompatActivity
import android.os.Bundle
import android.support.v7.widget.Toolbar
import android.view.Menu
import android.view.MenuItem
import android.widget.RadioButton
import android.widget.RadioGroup
import android.widget.Spinner

class MainActivity : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        val teamNameSpinner : Spinner = findViewById(R.id.teamNameSpinner)  // チーム名のトグルのやつ
        val radioGroup : RadioGroup = findViewById(R.id.teamGroup)  // ラジオボタン

        // 新規作成画面 … 個人のほうにチェック入れておく
        // 編集画面     … 初期値を読み込んでどちらかのラジオボタンにチェックを入れる
        val onlyButton : RadioButton = findViewById(R.id.onlyButton)
        onlyButton.isChecked = true
        teamNameSpinner.isClickable = false

        // ラジオボタンがチームを指しているときはスピナー(チーム名一覧)を有効化
        radioGroup.setOnCheckedChangeListener { _, checkedId ->
            val selectedRadioButton : RadioButton = findViewById(checkedId) // 選択中のラジオボタン
            teamNameSpinner.isClickable = ( selectedRadioButton == findViewById(R.id.teamButton) )
        }

        // メニューバー追加
        val myToolbar : Toolbar = findViewById(R.id.toolbar_writer)
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
    override fun onOptionsItemSelected(item: MenuItem) = when (item.itemId) {
        // 送信ボタン
        R.id.send -> {
            // ここに処理書く
            true
        }
        // 例外処理みたいなの
        else -> {
            // ユーザさんが予想外のことをしたよ！
            // パパに何とかしてもらうよ！
            super.onOptionsItemSelected(item)
        }
    }
}
