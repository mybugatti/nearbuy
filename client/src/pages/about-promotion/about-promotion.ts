import { Component } from '@angular/core';
import {NavController, NavParams, ViewController} from 'ionic-angular';

/*
  Generated class for the AboutPromotion page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-about-promotion',
  templateUrl: 'about-promotion.html'
})
export class AboutPromotionPage {

  constructor(public viewCtrl: ViewController,public navCtrl: NavController, public navParams: NavParams) { }

  close() {
    this.viewCtrl.dismiss();
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad AboutPromotionPage');
  }

}
