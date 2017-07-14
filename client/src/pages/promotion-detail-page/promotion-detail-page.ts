import {Component, ViewChild} from '@angular/core';
import {NavController, NavParams, PopoverController} from 'ionic-angular';
import {Map} from "../../components/map/map";
import {EnterprisePage} from "../enterprise/enterprise";
import {AboutPromotionPage} from "../about-promotion/about-promotion";
import {TimerPromotionPage} from "../timer-promotion/timer-promotion";

/*
  Generated class for the PromotionDetailPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-promotion-detail-page',
  templateUrl: 'promotion-detail-page.html'
})
export class PromotionDetailPagePage {

  @ViewChild(Map) getMaps:Map;
  promotionDetail:any;
  distance;
  min;
  lat;
  lng;
  color;

  @ViewChild(TimerPromotionPage) timer: TimerPromotionPage;

  date = "236500";

  constructor(public navCtrl: NavController, public navParams: NavParams, public popoverCtrl: PopoverController) {
    this.promotionDetail = navParams.data;

    this.lat = this.promotionDetail['dataLocal'].lat;
    this.lng = this.promotionDetail['dataLocal'].lng;
    this.color = this.promotionDetail['dataPromotion']['category'].color;
    console.log("", this.promotionDetail)

  }

  /**
   * Chargement de la carte google maps
   */
  ionViewDidLoad(){}

  ngOnInit(){
    //console.log("color=>", this.color)
    // use this if you want it to auto-start, hence the ViewChild import above.
    /* setTimeout(() => {
      this.timer.startTimer();
    }, 1000) */
  }

  ngAfterContentInit(){}

  traceItineraryOnMaps(){
    this.getMaps.getItinerary(this.lat,this.lng,this.color).then((res) => {
      this.distance = res['routes'][0]['legs'][0]['duration']['text'];
      this.min = res['routes'][0]['legs'][0]['distance']['text'];
    });
  }

  goToEnterprise(enterprise){
    this.navCtrl.push(EnterprisePage, enterprise);
  }

  /**
   *
   * @param event
   */
  presentPopover(event) {
    let popover = this.popoverCtrl.create(AboutPromotionPage);
    popover.present({ ev: event });
  }

}
