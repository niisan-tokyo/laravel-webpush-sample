@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// サービスワーカーが使えない系では何もしない
if ('serviceWorker' in navigator) {
  console.log('Service Worker and Push is supported');
  
  // サービスワーカーとして、public/sw.js を登録する
  navigator.serviceWorker.register('sw.js')
  .then(function (swReg) {
    console.log('Service Worker is registered', swReg)
    initialiseServiceWorker()
  })
  .catch(function(error) {
    console.error('Service Worker Error', error)
  })
}

/** 
 * サービスワーカーを初期化する
 * 初期化では、プッシュ通知用の情報をサーバに送ることになる
 */
function initialiseServiceWorker() {
  if (!('showNotification' in ServiceWorkerRegistration.prototype)) {
    console.log('cant use notification')
    return
  }

  if (Notification.permission === 'denied') {
    console.log('user block notification')
    return
  }

  if (!('PushManager' in window)) {
    consoleo.log('push messaging not supported')
    return
  }

  // プッシュ通知使えるので
  navigator.serviceWorker.ready.then(registration => {
    console.log(registration)
    registration.pushManager.getSubscription()
      .then(subscription => {
        if (! subscription) {
          subscribe(registration)
        }
      })
  })
}

/** 
 * サーバに自身の情報を送付し、プッシュ通知を送れるようにする
 */
function subscribe(registration) {
  var options = { userVisibleOnly: true }
  var vapidPublicKey = '{{ config("webpush.vapid.public_key") }}'

  if (vapidPublicKey) {
    options.applicationServerKey = urlBase64ToUint8Array(vapidPublicKey)
  }

  registration.pushManager.subscribe(options)
  .then(subscription => {
    updateSubscription(subscription)
  })
}

/** 
 * 購読情報を更新する
 *
 */
function updateSubscription(subscription) {
  var key = subscription.getKey('p256dh')
  var token = subscription.getKey('auth')
  var data = new FormData()
  data.append('endpoint', subscription.endpoint)
  data.append('key', key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null),
  data.append('token', token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null)

  // サーバに通信し、endpointを渡す
  fetch('/news/subscription', {
    method: 'POST',
    body: data
  }).then(() => console.log('Subscription ended'))
}

function urlBase64ToUint8Array (base64String) {
  var padding = '='.repeat((4 - base64String.length % 4) % 4);
  var base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/')
  var rawData = window.atob(base64)
  var outputArray = new Uint8Array(rawData.length)
  for (var i = 0; i < rawData.length; ++i) {
      outputArray[i] = rawData.charCodeAt(i)
  }
  return outputArray
}

</script>
@endsection