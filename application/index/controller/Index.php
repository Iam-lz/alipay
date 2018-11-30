<?php

namespace app\index\controller;

use AlipayOpenPublicTemplateMessageIndustryModifyRequest;
use AopClient;
use think\Controller;

include EXTEND_PATH.'alipay/AspSdk.php';

class Index extends Controller
{



    public function index()
    {
        $c = new AopClient();
        $c->gatewayUrl = "https://openapi.alipaydev.com/gateway.do";
        $c->appId = "2016092400583738";
        $c->rsaPrivateKey = 'MIIEowIBAAKCAQEAuFXckDgLyMiMJsff5GXxoqL6b0ZfwzB+lNtj6W0Z9qylhDBdiWAh4NSkhjKB1Ns7W/WHKiXQ559JEWL3408f8yUxN4g4HA1BngAt/BzBhhEUBEvycJk1y7gwmlch+1gZ2BNawKyS+AehqqLaajkmgkRf1C5ih4NmLTyCaqqnoSeASo0CRYW2Rs8PHD8MH/4oJRWnvat8S8wr10P/91NIVZnH01AQSqorhr7MTiaUS3jv3YEgcADFarkl01CX+qRUCTD1gQ0Jd0p97vMFw2o1pfrPa2AKawZictRJTC+5luzsFWx0YVaDLiAEjFHFwBjmD3baOIbJFb2vO2AdxSQHlwIDAQABAoIBAQCAqe25/GS9UL4Ck6CDG2T90CRdZxGQfFjeLgQe+jgVJYyiJ+Ah8yeydrofsUFOAXf9R/OAR8T45wVpTVsZHjF+1Yb06+++JMKYNifiwW+S1HjURu6CCW6zM205TXg6p9PiLiA6PDqZRTpikClD24A1jOQWhgnf7Kd1C7c8HMHEiU3GwF1RfinaQ6luXrHOcT0hST7JBFvaWu0OMdiKNfC60r0iH2R+GPepIrzS3W7rEj4/mXczHZkJvOTeBDZ0B0IDnuewnLL9Zx+Yi851haJo08hXbnraLSGXlKYUfaxs8fr/R2COglrw08RlvZoxMtc9h6+JNQkOVqu9g4CTs1iBAoGBAOmA2cMrMAwzgPGrWAj0bLAr2cLATEyMvafhwZFSoOFPANpNN3qclJZLd4RmY8elYTrKvAJW/XJMzb+rOw3Ob/MElaNz5cM/OggF0ThUTDbcdOXb+1ib003FYYN/BRA6fs1KmSZXdJWvHXncDplCqsoDhAlJLaA1UKCMFPpp+YbtAoGBAMoYVApxIDvkT0IkTHZWQzvgfBh2rvDlKd+wNdYWELfgs6gDHabL6nspwnUAxnXsvA3Mhqs8FiZk+4Y9s9MaZgp1sV/BBLDlcz3y6va0lCVjaSmy5zvVmhPYZLpJ94cvqw3FtU8rccS8nzXtxDQygA9rUQfRrzJZZgRGQ+VaVpQTAoGASzWybleZyURJkw3CdFfuLixhnoX7zWhDqjBf/aPkp82fk7DtXrPSdDpoi5/DIcoV8C7esc49IjS0zLilc8P7cQYYAKbS6bmSwoTFJ+SXC9CkYmkhox/FxrX9u7IM+nYs44jUnXHr3k6iKt8DYMAFbL4HKEqGxKSHjL6x/xplQd0CgYAGC0Q4K7nzEJjuOXev8lSAbe5ILQR+X9wovHRfurk1RpsY4z73xhF1LYKLTUKiNDpLj1pXtKxU6aA8G4xNO/ThSzPK0VL6l2Ii8Cjmx+/GTnrOrHMN7w10mnwoth2ZBWvwNYF+pKX6ZEm+qyW7CeeajnMV8Md0kgfjCNbu/Qyp0QKBgE7ph1q8+fNzBK+8zKDIV3+rQBRr/K/q0QRfB9EdQHPBmkf4YxOIr80hLmMvfXaZSjUpyO7oNS0AQqdLLW2Nr1j3bfJHMSnQGhqbXzS2DLTVb0shPNfRNa0HOG01fLI7ZAYM8BM+pWTu7O8io/1cQQFJfY6nIZwdlpHS/4hiqWzC';
        $c->format = "json";
        $c->charset = "UTF-8";
        $c->signType = "RSA2";
        $c->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuFXckDgLyMiMJsff5GXxoqL6b0ZfwzB+lNtj6W0Z9qylhDBdiWAh4NSkhjKB1Ns7W/WHKiXQ559JEWL3408f8yUxN4g4HA1BngAt/BzBhhEUBEvycJk1y7gwmlch+1gZ2BNawKyS+AehqqLaajkmgkRf1C5ih4NmLTyCaqqnoSeASo0CRYW2Rs8PHD8MH/4oJRWnvat8S8wr10P/91NIVZnH01AQSqorhr7MTiaUS3jv3YEgcADFarkl01CX+qRUCTD1gQ0Jd0p97vMFw2o1pfrPa2AKawZictRJTC+5luzsFWx0YVaDLiAEjFHFwBjmD3baOIbJFb2vO2AdxSQHlwIDAQAB';

        $request = new AlipayOpenPublicTemplateMessageIndustryModifyRequest();

        $request->bizContent = "{" .
            "    \"primary_industry_name\":\"IT科技/IT软件与服务\"," .
            "    \"primary_industry_code\":\"10001/20102\"," .
            "    \"secondary_industry_code\":\"10001/20102\"," .
            "    \"secondary_industry_name\":\"IT科技/IT软件与服务\"" .
            " }";
        $response = $c->execute($request);

    }

}

