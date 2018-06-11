package com.example.eccprog.dailyreport;

import android.content.AsyncTaskLoader;
import android.content.Context;
import android.widget.EditText;

import java.io.UnsupportedEncodingException;

public class MyLoader extends AsyncTaskLoader<String> {

    public MyLoader(Context context) {
        super(context);
    }

    @Override
    public void deliverResult(String data) {
        // Loderが処理した結果を返す。(メインスレッドで実行される)
        super.deliverResult(data);
    }

    @Override
    public String loadInBackground() {
//        PostApi postApi = new PostApi();
//        try {
//            postApi.Register();
//        } catch (UnsupportedEncodingException e) {
//            e.printStackTrace();
//        }

        String result = null;
//        try {
//            result = postApi.NewReport("Neko's", "test");
//        } catch (UnsupportedEncodingException e) {
//            e.printStackTrace();
//        }
        return result;
    }

    @Override
    protected void onStartLoading() {
        // Loder側の準備ができたタイミングで呼び出される
        // UIスレッドで実装される

        forceLoad();
    }
}
