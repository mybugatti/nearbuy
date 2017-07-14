import { Component } from '@angular/core';
import {NavController, NavParams, ViewController} from 'ionic-angular';

/*
  Generated class for the AboutEnterprise page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-about-enterprise',
  templateUrl: 'about-enterprise.html'
})
export class AboutEnterprisePage {

  constructor(public viewCtrl: ViewController,public navCtrl: NavController, public navParams: NavParams) { }

  close() {
    this.viewCtrl.dismiss();
  }
  ionViewDidLoad() {
    console.log('ionViewDidLoad AboutEnterprisePage');
  }

}
