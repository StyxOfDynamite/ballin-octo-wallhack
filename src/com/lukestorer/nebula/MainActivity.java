package com.lukestorer.nebula;

import android.app.Activity;
import android.os.Bundle;
import android.webkit.WebView;
import android.webkit.WebSettings;
import android.webkit.WebViewClient;
import android.net.Uri;
import android.content.Intent;


public class MainActivity extends Activity
{
	private WebView webView;
    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);

        /** Get URL from XML resources. */
        String url = getString(R.string.app_url);

        url = "http://" + url;

        /** Populate webview conponent and launch URL */
        webView = (WebView) findViewById(R.id.webview);
        webView.setWebViewClient(new WebViewClient() {
            @Override
            public boolean shouldOverrideUrlLoading(WebView view, String url) {
                String appUrl = getString(R.string.app_url);

                if (Uri.parse(url).getHost().equals(appUrl)) {
                    // This is my web site, so do not override; let my WebView load the page
                    return false;
                }
                // Otherwise, the link is not for a page on my site, so launch another Activity that handles URLs
                Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(url));
                startActivity(intent);
                return true;
            }
        });
		webView.getSettings().setJavaScriptEnabled(true);
		webView.loadUrl(url);
    }
}
