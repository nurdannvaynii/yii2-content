# READ ME

**KURULUM**

1. yii2 advanced template içinde,

       composer require nurdannvaynii/yii2-content
       
2. backend\config\main.php dosyasına modülü ekliyoruz.
 
       
       'modules' => [
         'content' => [
         'class' => 'nurdannvaynii\content\Module'
       ]
      ],
      
3. Migration Ayarları

     
      php yii migrate/up --migrationPath=@vendor/nurdannvaynii/yii2-content/migrations
      
4. Vagrant Up ile makine ayağa kaldırılır.

Backend İçin; 

    advanced/backend/web/index.php?r=content/index
    
yolu ile ulaşılır.