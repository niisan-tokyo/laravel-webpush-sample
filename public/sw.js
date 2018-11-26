'use strict'

self.addEventListener('install', function (e) {
  console.log('ServiceWorker install')
})

self.addEventListener('activate', function (e) {
  console.log('Serviceworker activated')
})

const WebPush = {
  init () {
    self.addEventListener('push', this.notificationPush.bind(this))
    self.addEventListener('notificationclick', this.notificationClick.bind(this))
    self.addEventListener('notificationclose', this.notificationClose.bind(this))
  },

  /**
   * handle notification push event!
   * @param {NotificationEvent} event 
   */
  notificationPush(event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
      return
    }

    if (event.data) {
      event.waitUntil(
        this.sendNotification(event.data.json())
      )
    }
  },

  /**
   * handle notification click event
   * @param {NotificationEvent} event 
   */
  notificationClick(event) {
    self.clients.openWindow('/')
  },

  /**
   * handle notification close event
   * @param {NotificationEvent} event 
   */
  notificationClose(event) {
    self.clients.openWindow('/')
    // self.registration.pushManager.getSubscription().then(subscription => {
    //   if (subscription) {
    //     this.dismissNotification(event, subscription)
    //   }
    // })
  },

  /**
   * send request to server to dismiss a notification
   * @param {PushMessageData|Object} data 
   */
  sendNotification(data) {
    return self.registration.showNotification(data.title, data)
  },
}

WebPush.init()