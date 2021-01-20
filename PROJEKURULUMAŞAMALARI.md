# PROJE KURULUM AŞAMALARI


İlk olarak project klasörü oluşturuldu, project klasörünün yolunda;
//C:\Users\NurdanVayni\Documents\project 

mkdir vagrant

             vagrant klasörü açıyorum içinde ve klasörün içine giriyorum.

cd vagrant

vagrant init ubuntu/xenial32  //minimum konfigürasyonunu kur demek istiyorum (kullanacağım makinenin adını söylüyorum.)

ls 

//ile vagrant dosyasının içini kontrol ettiğimizde gördüğümüz üzere bir vagrantfile oluşturdu.
 
Şimdi herhangi bir IDE ile klasörü açıyorum, ben Visual Studio Code kullanmayı tercih ettim bundan dolayı proje dosyamı Visual Studio Code ile açtım.

vagrant klasörü altına bir tane config klasörü oluşturdum, bunların içine dosyaları oluşturucam.
config altında konfigürasyonları almak için bir tane,

vagrant-local-example.yml ve vagrant-local.yml dosyasına ihtiyacımız var.

vagrant-local-example.yml ve vagrant-local.yml dosyalarının içini düzenliyoruz.

vagrant-local.yml ->
Token almamız gerekiyor, bunun için;
Github hesabına giriş yaptıktan sonra, 

Settings -> Developer Settings -> Personal access tokens -> Generate new token
//Şifre girişini sağladıktan sonra devam ediyoruz.
Note kısmına token adını giriyoruz, dilediğiniz herhangi bir ad verilebilir.
Bu noktada sadece repo kısmını işaretlemek yeterlidir.
Generate token
dedikten sonra token oluşturulmuş olacaktır.

Oluşturulan token’ı kopyalayıp <your-personal-github-token>
yerine yapıştırıyoruz. Bu aslında bizim için bir konfigürasyon, değişken dosyası.


Vagrantfile içinde;

require 'yaml'
require 'fileutils' 

kütüphanelerine ihtiyaç duyuyoruz, çünkü bu dosyaları okuyacağız ve konfigürasyonları ekleyeceğiz.

domains = {
portalproject : ‘portalproject’
}
           
//Domain alanı ekliyoruz ve domain tanımlaması yapıyoruz, bu bizim anahtar                     kelimemiz olucak.

//config değişkeni oluşturucaz.

config = {
local : ‘./config/vagrant-local.yml’,
example : ‘./config/vagrant-local-example.yml’ //Olmama durumunda uyarı versin diye bunu da ekliyoruz.
}

Burada konfigürasyonumuzun temel değişkenlerini belirledik. Şimdi dosyadan okuma işlemi yapıcaz.

     FileUtils.cp config[:example], config[:local] unless File.exist?(config[:local])
     options = YAML.load_file[:local]
     
Github tokenını kontrol ettiğimiz bölüm :

    if options['github_token'].nil? || options['github_token'].to_s.length != 40
    puts "You must place REAL GitHub token into configuration:\n/vagrant/config/vagrant-    local.yml" exit end

options arrayindeki github tokenının tanımlı olup olmadığını ve 40 karakter uzunlukta tanımlı olup olmadığını kontrol ediyor, eğer token buna uymuyorsa bir uyarı mesajı basıyor.

     Vagrant.configure("2") do |config|
     config.vm.box = "ubuntu/xenial32"
     end

içine;

     config.vm.box_check_update = options['box_check_update'] 

ekliyoruz.  Bu komut satırında açılışta box update etsin mi etmesinmi 

Makinenin provider ayarları;

    config.vm.provider 'virtualbox' do |vb|
    # machine cpus count
    vb.cpus = options['cpus']
    # machine memory size
    vb.memory = options['memory']
    # machine name (for VirtualBox UI)
    vb.name = options['machine_name']
    end

Tekrar tanımlamaları yapıyoruz vagrant konsolu için;

    # machine name (for vagrant console)
    config.vm.define options['machine_name']
 
    # machine name (for guest machine console)
    config.vm.hostname = options['machine_name']

Makineye bir IP adresi ver;

    # network settings
    config.vm.network 'private_network', ip: options['ip']

Şimdi vagrant klasörünün dışında yukarıda tanımladığım domain ile ifade ettiğim isim ile aynı olan bir klasör oluşturuyoruz. 

**portalproject**

Yazılacak kodlar burada yazılacaktır vagrant sunucusunda ise çalıştırılacaktır.

Makine ile bu klasör arasında bir bağ kurmam lazım eşleşen klasör sync: folder özelliği bunu yapıyor : 

    # sync: folder 'portal' (host machine) -> folder '/var/www/portal' (guest machine)
    config.vm.synced_folder '../portalproject', '/var/www/portalproject', id: "vagrant-   portalproject",
    owner: "vagrant",
    group: "www-data",
    mount_options: ["dmode=775,fmode=664"]

    # disable folder '/vagrant' (guest machine)
    config.vm.synced_folder '.', '/vagrant'

    # hosts settings (host machine)
    config.vm.provision :hostmanager
    config.hostmanager.enabled            = true
    config.hostmanager.manage_host        = true
    config.hostmanager.ignore_private_ip  = false
    config.hostmanager.include_offline    = true
    config.hostmanager.aliases            = domains.values
 
    # provisioners
    config.vm.provision 'shell', path: './provision/once-as-root.sh', args:           
    [options['timezone']]
    config.vm.provision 'shell', path: './provision/always-as-root.sh', run: 'always'
    
apache2 ve provision klasörlerini oluşturuyoruz.

provision klasörünün altına,
**always-as-root.sh** dosyası oluşturuyoruz.

sh linux dosyalarda çalıştırılabilir betik dosyasıdır.

always-as-root.sh dosyasının içine aşağıdaki kod satırlarını kopyala yapıştır yapıyoruz.

    #!/usr/bin/env bash
 
    #== Bash helpers ==
 
    function info {
      echo " "
      echo "--> $1"
      echo " "
    }
 
    #== Provision script ==
 
    info "Provision-script user: `whoami`"
 
    info "Restart web-stack"
    service apache2 restart
    service mysql restart


Yaptığı şeyi bir programı çalıştırmak gibi düşünebiliriz.
Makine her çalıştığında bir servis olarak apache2 yi ve mysql’i çalıştırıyor.

Şimdi de bir kez çalıştırılacak olan bir betik oluşturuyoruz. Yine provision klasörünün altında once-as-root.sh dosyası şeklinde oluşturuyoruz. Dosya biraz uzun çünkü tüm kurulumu gerçekleştiren asıl dosyadır.

‘portalproject’ benim anahtar kelimem oluyor. Bu anahtar kelime benim konfigürasyon içinde kullanacağım anahtar kelime olacak. apache2 klasörü içinde yayınlanmasını istediğim web sitelerimin konfigürasyon dosyalarını bu isimle oluşturucam ve uzantıları da conf olacak.

Yani apache2 klasörünün altına portalproject.conf dosyasını oluşturuyoruz ve içini doldur.


**Not:** Bizim anahtar kelimemiz olan portalproject olan yerler belirlenen anahtar kelime ile değiştirilir.

always-as-root.sh her açılışta çalışır.
once-as-root.sh bir kere up yapıldığında çalışır.

Argüman olarak 2.parametre olarak github token da almamız gerekiyor.

    github_token=$(echo "$2")

Ekrana bassın : 

    function info {
      echo " "
      echo "--> $1"
      echo " "
      echo " "
      echo "--> $2"
      echo " "
    }
    
 Vagrantfile’a da ekliyoruz.

     # provisioners
    config.vm.provision 'shell', path: './provision/once-as-root.sh', args:     
    [options['timezone'],options['github_token']]

Çalıştırmadan önce hostmanager pluginini yüklüyoruz, host dosyasını düzenlemeye yarıyor.

    vagrant plugin install vagrant-hostmanager

Çalıştırmak İçin :
Vagrant dizinize gidiyoruz,

    Vagrant up

Vagrant status ile makinenin durumunu kontrol edebiliriz.
Bir ayar değiştirmek istediğimiz zaman Vagrant reload
Kapatmak istediğimizde Vagrant halt

portalproject klasörümün içinde index.php dosyası oluşturuyorum.
http://portalproject ile index.php de yazdığım kod satırları çalışıyor.

Makineye bağlanmak için 2 yöntem var;

    Vagrant ssh
    ssh vagrant@projectmachine

advanced anahtar kelimesi 

proje dosyasını php stormda açıyoruz

    vagrant ssh
    cd /var/www
    composer create-project --prefer-dist yiisoft/yii2-app-advanced
    cd advanced/
    php requirements.php
    
çalıştırarak projede varsa bir konfigürasyon eksiği onları bize söylüyor.

    php init

proje içerisinde oluşacak konfigürasyon dosyalarını kullanabiliyoruz bu şekilde.

    php yii migrate



