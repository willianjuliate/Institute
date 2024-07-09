<?php

/**
 * DATABASE
 */
const CONF_DB_HOST = "localhost";
const CONF_DB_USER = "root";
const CONF_DB_PASS = "";
const CONF_DB_NAME = "institute_developer";

/**
 * SITE
 */
const CONF_SITE_NAME = "";
const CONF_SITE_LANG = "";
const CONF_SITE_DOMAIN = "";

/**
 * SOCIAL
 */
const CONF_SOCIAL_TWITTER_CREATOR = "";
const CONF_SOCIAL_TWITTER_PUBLISHER = "";
const CONF_SOCIAL_FACEBOOK_APP = ""; // developers.facebook
const CONF_SOCIAL_FACEBOOK_PAGE = "";
const CONF_SOCIAL_FACEBOOK_AUTHOR = "";

/**
 * PROJECT URLs
 */
const CONF_URL_BASE = "https://www.institute.me";
const CONF_URL_ADMIN = CONF_URL_BASE . "/admin";
const CONF_URL_ERROR = CONF_URL_BASE . "/404";
const CONF_PATH_VIEW = __DIR__ . "../../../App/Views/";

/**
 * DATES
 */
const CONF_DATE_BR = "d/m/Y H:i:s";
const CONF_DATE_APP = "Y-m-d H:i:s";

/**
 * SESSION
 */
const CONF_SES_PATH = __DIR__ . "/../../storage/sessions/";

/**
 * PASSWORD
 */
const CONF_PASSWD_MIN_LEN = 8;
const CONF_PASSWD_MAX_LEN = 40;
const CONF_PASSWD_ALGO = PASSWORD_DEFAULT;
const CONF_PASSWD_OPTION = ["cost" => 10];

/**
 * MESSAGE
 */
const CONF_MESSAGE_CLASS = "trigger";
const CONF_MESSAGE_INFO = "info";
const CONF_MESSAGE_SUCCESS = "success";
const CONF_MESSAGE_WARNING = "warning";
const CONF_MESSAGE_ERROR = "error";

/*
 * VIEW
 * */

const CONF_VIEW_PATH = __DIR__ . "/../../assets/views/";
const CONF_VIEW_EXT = "phtml";


/**
 * UPLOAD
 */
const CONF_UPLOAD_DIR = "../storage/uploads";
const CONF_UPLOAD_IMAGE_DIR = "images";
const CONF_UPLOAD_FILE_DIR = "files";
const CONF_UPLOAD_MEDIA_DIR = "medias";

/**
 * IMAGENS
 */
const CONF_IMAGE_CACHE = CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . '/cache';
const CONF_IMAGE_SIZE = 2000;
const CONF_IMAGE_QUALITY = ['jpg' => 75, 'png' => 5];

/**
 * MAIL
 */
const CONF_MAIL_HOST = "smtp.office365.com";
const CONF_MAIL_PORT = 587;
const CONF_MAIL_USER = "";
const CONF_MAIL_PASS = "";
const CONF_MAIL_SENDER = [
    "name" => "",
    "address" => ""
];
const CONF_MAIL_OPTION_LANG = "br";
const CONF_MAIL_OPTION_HTML = true;
const CONF_MAIL_OPTION_AUTH = true;
const CONF_MAIL_OPTION_SECURE = "tls";
const CONF_MAIL_OPTION_CHARSET = "utf-8";

/*
 * ASSETS
 */
const CONF_PATH_CSS = "/css/";
const CONF_PATH_JS = "/js/";