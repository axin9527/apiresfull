<?php
class ErrorCode{
    const USERNAME_EXISTS = 1;
    const PASSWORD_NOT_EMPTY = 2;//检测密码不能为空
    const USERNAME_NOT_EMPTY = 3;//用户名不能为空
    const REGIST_NOT = 4;//注册失败
    const USERNAME_PASSWORD_NOT_EMPTY = 5;//用户名或密码错误
    const TITLE_NOT_EMPTY = 6;//标题不能为空
    const CONTENT_NOT_EMPTY = 7;//内容不能为空
    const TITLE_CONTENT_WRONG = 8;//标题或者文章错误
    const ARTICLEID_NOT_EMPTY = 9;//文章编号ID不能为空
    const ARTICLE_NOT_EXISTIS = 10;//文章不存在1
    const EDIT_NOT_AUTH = 11;//无权编辑
}