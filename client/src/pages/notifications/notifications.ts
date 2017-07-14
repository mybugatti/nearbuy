import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import {AccueilPage} from "../accueil/accueil";
import {FilterProvider} from "../../providers/filter-provider";

/*
  Generated class for the Notifications page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-notifications',
  templateUrl: 'notifications.html'
})
export class NotificationsPage {

  promotionCategory: Array<{name: string, color: string, isChecked: boolean}> = [];

  constructor(public navCtrl: NavController, public navParams: NavParams, public notification: FilterProvider) {

    this.notification.loadCategory().then((data) => {

      data.forEach(dataCategory => {
        this.promotionCategory.push({
          name: dataCategory.name,
          color: dataCategory.color,
          isChecked: (data.indexOf(dataCategory.name) === -1)
        });
      });
    }, (err) => {
      console.log("error", err);
    });

  }

  ionViewDidLoad() {}

  /**
   *
   */
  close(){
    this.navCtrl.setRoot(AccueilPage, {}, {animate: true, direction: 'back'});
  }

}
