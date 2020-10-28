<?php

return [
    '403'       => [
        'body'  => 'Görünüşe göre bu sayfaya erişim izniniz yok!',
        'title' => 'İzin Reddedildi',
    ],
    '403-form'  => [
        'help'  => 'Bu oturumunuzun zaman aşımına uğraması nedeniyle gerçekleşmiş olabilir. Lütfen kaydetmeden önce başka bir ekranda giriş yapmayı deneyin.',
    ],
    '404'       => [
        'body'  => 'Üzgünüz, aradığınız sayfa bulunamadı.',
        'title' => 'Sayfa Bulunamadı',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Eyvah, görünüşe göre bir şeyler yanlış gitti.',
            '2' => 'Karşılaşılan sorunun bir raporu bize iletildi, ancak bazen ne yaptığınız hakkında daha fazla şey bilmemiz yardımcı olur.',
        ],
        'title' => 'Hata',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Kanka şu anda bakımda, ki bu bir güncelleme yolda demektir!',
            '2' => 'Rahatsızlık için özür dileriz. Her şey sadece birkaç dakika içinde normale dönecek.',
        ],
        'title' => 'Bakım',
    ],
    '503-form'  => [
        'body'  => 'Verinizi doğru şekilde kaydedemedik, ki buna iki faktörden biri sebep olur. Lütfen Kanka\'yı :link ile açın. Eğer uygulama bakımda ise, uygulama tekrar çalışır hale gelene kadar lütfen verinizi başka bir yerde kaydedin. Eğer karşınıza "Tarayıcınız kontrol ediliyor" mesajı gelirse, tekrardan Kaydet tuşuna tıklamayı deneyebilirsiniz.',
        'link'  => 'yeni pencere',
        'title' => 'Beklenmeyen bir şey oldu.',
    ],
    'footer'    => 'Eğer daha fazla yardıma ihtiyacınız varsa, lütfen bize hello@kanka.io adresinden ya da :discord üzerinden ulaşın.',
];
