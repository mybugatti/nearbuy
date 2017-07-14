import { Component } from '@angular/core';
import {NavController, NavParams, PopoverController} from 'ionic-angular';
import {AboutEnterprisePage} from "../about-enterprise/about-enterprise";

/*
  Generated class for the Enterprise page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-enterprise',
  templateUrl: 'enterprise.html'
})
export class EnterprisePage {

  enterprise;
  cards: any;
  category: string = 'gear';

  constructor(public navCtrl: NavController, public navParams: NavParams, public popoverCtrl: PopoverController) {
    this.enterprise = navParams.data;
    this.cards = new Array(3);
  }

  ionViewDidLoad() {}

  presentPopover(event) {
    let popover = this.popoverCtrl.create(AboutEnterprisePage);
    popover.present({ ev: event });
  }

}
