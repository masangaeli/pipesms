package com.aifrruislabs.apps.pipesms.utils;

public class ServerParam {

    //Base Server
    public static String baseServer = "https://pipesms.aifrruislabs.com";

    //Main Url
    public static String apiUrl = baseServer + "/api/v1";

    //Login Url
    public static String loginUrl = apiUrl + "/mobile/interface/login";

    //Post Delivered SMS Status Url
    public static String postDeliveredSMSUrl = apiUrl + "/mobile/interface/clear/delivery/rpt";

    //Post Sent SMS Status Url
    public static String postSentSMSUrl = apiUrl + "/mobile/interface/clear/outgoing";

    //Get SMS List to Be Sent
    public static String getSMSListToSendUrl = apiUrl + "/get/action/outgoing/sms";
}
