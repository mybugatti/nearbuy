import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import {AccueilPage} from "../accueil/accueil";

/*
 Generated class for the ScanResult page.
 See http://ionicframework.com/docs/v2/components/#navigation for more info on
 Ionic pages and navigation.
 */
@Component({
  selector: 'page-scan-result',
  templateUrl: 'scan-result.html'
})
export class ScanResultPage {
  public scannedText: string;

  constructor(public nav: NavController, public navCtrl: NavController, private _navParams: NavParams) {}

  ionViewDidLoad() {
    this.scannedText = this._navParams.get("scannedText");
  }

close(){
    //this.nav.setRoot(AccueilPage);
    this.nav.setRoot(AccueilPage, {}, {animate: true, direction: 'forward'});
}
}