package com.example.eccprog.dailyreport

import android.app.LoaderManager
import android.content.Loader
import android.support.v7.app.AppCompatActivity
import android.os.Bundle
import android.support.v7.widget.Toolbar
import android.view.Menu
import android.view.MenuItem
import android.text.method.ScrollingMovementMethod
import android.util.Log
import android.widget.*
import kotlinx.android.synthetic.main.activity_writer.*


class WriterActivity() : AppCompatActivity(), LoaderManager.LoaderCallbacks<String> {
//
//    private lateinit var teamName: String  // チーム名

//    teamName =

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_writer)

        // 編集画面かどうか(true=編集画面/False=新規画面)
//        val editFlag = true

        val teamNameSpinner: Spinner = findViewById(R.id.teamNameSpinner)  // チーム名のトグルのやつ
        val radioGroup: RadioGroup = findViewById(R.id.teamGroup)  // ラジオボタン

        // 新規作成画面 … 個人のほうにチェック入れておく
        // 編集画面     … 初期値を読み込んでどちらかのラジオボタンにチェックを入れる
        val onlyButton: RadioButton = findViewById(R.id.onlyButton)
        onlyButton.isChecked = true
        teamNameSpinner.isClickable = false

        // 編集画面なら本文、日付、作成者をもらう


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

    override fun onCreateLoader(id: Int, args: Bundle): Loader<String> {
        // Loaderを初期化する
        return MyLoader(this)
    }

    override fun onLoadFinished(loader: Loader<String>, data: String?) {
        // dataでは、Loaderクラスの戻り値が返される
        // Loaderの終了処理
        Log.d("", "onLoadFinished")
    }

    override fun onLoaderReset(arg0: Loader<String>) {
        // Loaderが、リセットされるときに呼ばれる。
        // ここで、もらっているdataを破棄する必要がある。
        Log.d("", "onLoaderReset")
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

            val editText : EditText = findViewById(R.id.editText)   // 本文
            val bundle = Bundle()
            bundle.putString("teamName", "北海道ガラナ")
            bundle.putString("main", editText.text.toString())
            // 非同期スレッドの初期化
            loaderManager.initLoader(0, bundle, this)
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