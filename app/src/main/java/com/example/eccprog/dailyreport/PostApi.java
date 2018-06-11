package com.example.eccprog.dailyreport;

import android.content.AsyncTaskLoader;
import android.util.Log;

import org.apache.http.HttpResponse;
import org.apache.http.HttpStatus;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.List;

/*
 * ここにPOST用のやつ作って呼び出す
 * IDとパスはここにおいておく
 * (二つのsetとclearメソッドも作る予定)
 * (パスはハッシュ化したい)
 */
public class PostApi {

//    public String id = null;
//    public String password = null;
    public String id = "YTanaka";
    public String password = "testpass";
    public String name = "ねこさん";
    private String baseUrl = "http://10.0.2.2/";

    /**
     * 新しい日報を投稿
     * @param team チーム名
     * @param main 本文
     * @return 投稿に成功したかどうか
     */
    public String NewReport(String team, String main) throws UnsupportedEncodingException {
        // POST Requestを構築する。
        HttpPost request = new HttpPost(baseUrl + "api/newReport.php");

        List<NameValuePair> params = new ArrayList<NameValuePair>();
        params.add(new BasicNameValuePair("id", id));
        params.add(new BasicNameValuePair("password", password));
        params.add(new BasicNameValuePair("team", team));
        params.add(new BasicNameValuePair("main", main));
        request.setEntity(new UrlEncodedFormEntity(params));

        // HttpClientインタフェースではなくて、実クラスのDefaultHttpClientを使う。
        // 実クラスでないとCookieが使えないなど不都合が多い。
        DefaultHttpClient httpClient = new DefaultHttpClient();
        try {
            String result = httpClient.execute(request, new ResponseHandler<String>() {
                @Override
                public String handleResponse(HttpResponse response)
                        throws ClientProtocolException, IOException {

                    // response.getStatusLine().getStatusCode()でレスポンスコードを判定する。
                    // 正常に通信できた場合、HttpStatus.SC_OK（HTTP 200）となる。
                    switch (response.getStatusLine().getStatusCode()) {
                        case HttpStatus.SC_OK:
                            // レスポンスデータを文字列として取得する。
                            // byte[]として読み出したいときはEntityUtils.toByteArray()を使う。
                            return EntityUtils.toString(response.getEntity(), "UTF-8");

                        case HttpStatus.SC_NOT_FOUND:
                            throw new RuntimeException("データないよ！");

                        default:
                            throw new RuntimeException("なんか通信エラーでた");
                    }

                }
            });

            // logcatにレスポンスを表示
            Log.d("test", result);

            // finallyから移動(ここじゃないとresultを拾えない)
            httpClient.getConnectionManager().shutdown();
            return result;
        } catch (ClientProtocolException e) {
            throw new RuntimeException(e);
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
    }

//    public String Register() throws UnsupportedEncodingException {
    public void Register() throws UnsupportedEncodingException {
        // POST Requestを構築する。
        HttpPost request = new HttpPost(baseUrl + "api/register.php");

        List<NameValuePair> params = new ArrayList<NameValuePair>();
        params.add(new BasicNameValuePair("id", id));
        params.add(new BasicNameValuePair("name", name));
        params.add(new BasicNameValuePair("password", password));
        request.setEntity(new UrlEncodedFormEntity(params));

        // HttpClientインタフェースではなくて、実クラスのDefaultHttpClientを使う。
        // 実クラスでないとCookieが使えないなど不都合が多い。
        DefaultHttpClient httpClient = new DefaultHttpClient();
        try {
            String result = httpClient.execute(request, new ResponseHandler<String>() {
                @Override
                public String handleResponse(HttpResponse response)
                        throws ClientProtocolException, IOException {

                    // response.getStatusLine().getStatusCode()でレスポンスコードを判定する。
                    // 正常に通信できた場合、HttpStatus.SC_OK（HTTP 200）となる。
                    switch (response.getStatusLine().getStatusCode()) {
                        case HttpStatus.SC_OK:
                            // レスポンスデータを文字列として取得する。
                            // byte[]として読み出したいときはEntityUtils.toByteArray()を使う。
                            return EntityUtils.toString(response.getEntity(), "UTF-8");

                        case HttpStatus.SC_NOT_FOUND:
                            throw new RuntimeException("データないよ！");

                        default:
                            throw new RuntimeException("なんか通信エラーでた");
                    }

                }
            });

            // logcatにレスポンスを表示
            Log.d("test", result);

            // finallyから移動(ここじゃないとresultを拾えない)
            httpClient.getConnectionManager().shutdown();
//            return result;
        } catch (ClientProtocolException e) {
            throw new RuntimeException(e);
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
    }
}
