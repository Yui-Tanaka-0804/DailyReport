//package com.example.eccprog.dailyreport
//
//import com.google.gson.GsonBuilder
//import okhttp3.Interceptor
//import okhttp3.OkHttpClient
//import okhttp3.logging.HttpLoggingInterceptor
//import retrofit2.Call
//import retrofit2.Retrofit
//import retrofit2.converter.gson.GsonConverterFactory
//import retrofit2.http.Field
//import retrofit2.http.FormUrlEncoded
//import retrofit2.http.POST
//import java.util.concurrent.TimeUnit
//
//interface ApiService {
//    @FormUrlEncoded
//    @POST("api/newReport")
//    fun newReport(@Field("id") id: String, @Field("password") password: String,
//                  @Field("team") team: String, @Field("main") main: String)
//            : Call<User>
//
//    data class Send(var id: String,
//                    var password: String,
//                    var team: String,
//                    var main: String)
//
//    data class Return(var result: String)
//
//    val httpBuilder: OkHttpClient.Builder get() {
//        // create http client
//        val httpClient = OkHttpClient.Builder()
//                .addInterceptor(Interceptor { chain ->
//                    val original = chain.request()
//
//                    //header
//                    val request = original.newBuilder()
//                            .header("Accept", "application/json")
//                            .method(original.method(), original.body())
//                            .build()
//
//                    return@Interceptor chain.proceed(request)
//                })
//                .readTimeout(30, TimeUnit.SECONDS)
//
//        // log interceptor
//        val loggingInterceptor = HttpLoggingInterceptor()
//        loggingInterceptor.level = HttpLoggingInterceptor.Level.BODY
//        httpClient.addInterceptor(loggingInterceptor)
//
//        return httpClient
//    }
//
//    // core for controller
//    val service: ApiService = create(ApiService::class.java)
//
//    lateinit var retrofit: Retrofit
//
//    fun <S> create(serviceClass: Class<S>): S {
//        val gson = GsonBuilder()
//                .serializeNulls()
//                .create()
//
//        // create retrofit
//        retrofit = Retrofit.Builder()
//                .addConverterFactory(GsonConverterFactory.create(gson))
//                .baseUrl("http://randomuser.me/") // Put your base URL
//                .client(httpBuilder.build())
//                .build()
//
//        return retrofit.create(serviceClass)
//    }
//
//}
