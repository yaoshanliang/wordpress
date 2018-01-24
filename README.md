# A framework based on wordpress

## 特点

 * 禁用google字体
 * 关闭版本升级提示
 * 替换Gravatar链接
 * 优化系统打开速度
 * 移除其它无用内容
 
 
## 安装
 
 * 克隆代码
 * 修改根目录wp-config文件为自己的数据库地址、账号、密码
        
        define('DB_NAME', '');
        define('DB_USER', '');
        define('DB_PASSWORD', '');
        define('DB_HOST', '');
            
 * 导入根目录wordpress.sql默认数据
 * 修改数据库配置为项目网址
         
        update `wp_options` set `option_value` = '项目网址' where `option_id` = 1;
        update `wp_options` set `option_value` = '项目网址' where `option_id` = 2;
  
     
## 访问
    
 * 账号: admin, 密码: admin