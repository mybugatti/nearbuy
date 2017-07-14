import {Component, ViewChild} from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import {PromotionService} from "../../app/services/promotion.service";
import {LocalService} from "../../app/services/local.service";
import {UserService} from "../../app/services/user.service";
import {EntrepriseService} from "../../app/services/entreprise.service";
import {TimerPromotionPage} from "../timer-promotion/timer-promotion";

/*
  Generated class for the EnterpriseShop page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-enterprise-shop',
  templateUrl: 'enterprise-shop.html'
})
export class EnterpriseShopPage {

  cards: any;
  category: string = 'gear';
  @ViewChild(TimerPromotionPage) timer: TimerPromotionPage;

  date = "36500";

  constructor(
    public navCtrl: NavController,
    public navParams: NavParams,
    public promo: PromotionService,
    public local: LocalService,
    public  user: UserService,
    public entreprise: EntrepriseService)
  {

    this.cards = new Array(1);
  }

  ngOnInit() {
    // use this if you want it to auto-start, hence the ViewChild import above.
    setTimeout(() => {
      this.timer.startTimer();
    }, 1000)
  }

  getPromotion(){
    this.promo.getPromotions();
    console.log("all promotion=>", this.promo.getPromotions());
  }

  getLocal(){
    this.local.getLocals();
    console.log("all local =>", this.local.getLocals());
  }

  getEntreprise(){
    console.log("all Entreprise =>", this.entreprise.getEntreprises());
  }

  getUser(){
    console.log("all User =>", this.user.getUsers());
  }
}
