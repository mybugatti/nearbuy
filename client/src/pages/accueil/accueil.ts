import {Component, OnInit} from '@angular/core';
import {
  NavController, NavParams, MenuController, AlertController, ItemSliding, ModalController,
  Platform
} from 'ionic-angular';
import { IonPullUpFooterState} from '../../app/ionic-pullup/ion-pullup';
import {MapProvider} from "../../providers/map-provider";
import {PromotionDetailPagePage} from "../promotion-detail-page/promotion-detail-page";
import {FilterPage} from "../filter/filter";
import {FilterProvider} from "../../providers/filter-provider";
import {EnterprisePage} from "../enterprise/enterprise";
import {LocalService} from "../../app/services/local.service";
import {FavouriteService} from "../../app/services/favourite.service";
import {FavouriteEntrepriseService} from "../../app/services/favouriteEntreprise.service";
import {addToArray} from "@angular/core/src/linker/view_utils";
/*
 Generated class for the Accueil page.

 See http://ionicframework.com/docs/v2/components/#navigation for more info on
 Ionic pages and navigation.
 */
@Component({
  selector: 'page-accueil',
  templateUrl: 'accueil.html'
})
export class AccueilPage implements OnInit {

  footerState: IonPullUpFooterState; // variable footer
  _favorites = []; // favorites
  filterResult: any = [];
  contentCategory: any = [];

  segment = 'all';
  excludePromotion = [];

  promotion: string = "news"; // model
  promotionItems: any;
  popularitePromotion: any;
  items = [];
  /**
   *
   * @param navCtrl
   * @param navParams
   * @param menu
   * @param alertCtrl
   */
  constructor(public navCtrl: NavController,
              public filter: FilterProvider,
              public modalCtrl: ModalController,
              public navParams: NavParams,
              public menu: MenuController,
              public alertCtrl: AlertController,
              public  map: MapProvider,
              public local: LocalService,
              public platform: Platform,
              public fav: FavouriteService,
              public ent: FavouriteEntrepriseService
  ) {}

  /**
   * Initialisation :
   */
  ngOnInit(){
    this.menu.swipeEnable(true);
    this.footerState = IonPullUpFooterState.Collapsed;
  }

  ionViewDidLoad(){

    this.platform.ready().then(() => {
      this.getAllPromotion();
    });
  }

  /**
   *
   * @returns {Promise<T>}
   */
  getAllPromotion(){

    if (this.promotionItems) {
      // already loaded data
      return Promise.resolve(this.promotionItems);
    }

    this.map.loadLocations().then((data) => {
      this.promotionItems = data;
    }, (err) => {
      console.log("error", err);
    });

  }

  /**
   *
   */
  popularPromotion(){

    let tabPopular = [];

    this.promotionItems.forEach((data) => {

      let popular = {
        nbUsed: data['dataPromotion'].nbUsed,
        dataPromotion: data['dataPromotion'],
        dataLocal: data['dataLocal'],
        lat: data.lat,
        lng: data.lng,
        maxDistance: data.maxDistance,
        placeLocation: data.placeLocation
      }
      addToArray(popular, tabPopular);

    });

    tabPopular.sort((x, y)=> {
      return y.nbUsed - x.nbUsed;
    });

    this.popularitePromotion = tabPopular;

  }

  ionViewDidEnter(){}

  updateSchedule(){
    this.filterSearch();
  }

  /**
   * Function:
   */
  presentFilter() {

    let modal = this.modalCtrl.create(FilterPage, this.excludePromotion);
    modal.present();

    modal.onDidDismiss((data: any[], dataC:any[]) => {
      if (data || dataC) {
        this.excludePromotion = data;
        this.contentCategory = dataC;
        this.updateSchedule();
      }
    });
  }

  /**
   *
   */
  filterSearch(){

    let tabC = [];
    let tabContent = [];
    let tabExclu = this.excludePromotion;

    this.promotionItems.filter((f) => {
      if (tabContent.indexOf(f['dataPromotion']['category'].name) < 0) {
        tabContent.push(f['dataPromotion']['category'].name)
      }
    });

    let diff = tabContent.filter(function(item) {
      return tabExclu.indexOf(item) === -1;
    });

    this.promotionItems.forEach(cat => {

      diff.forEach(name => {

        if(cat['dataPromotion']['category'].name === name ) {

          tabC.push(cat)
          this.filterResult = tabC || [];

        }

      });

    });

  }

  /**
   *
   * @param refresher
   */
  doRefresh(refresher) {
    setTimeout(() => {
      refresher.complete();
    }, 2000);
  }

  footerExpanded() {}

  footerCollapsed() {}

  /**
   *
   */
  toggleFooter() {
    this.footerState = this.footerState == IonPullUpFooterState.Collapsed ? IonPullUpFooterState.Expanded : IonPullUpFooterState.Collapsed;
  }

  /**
   *
   * @param promotionData
   */loadLocations
  goToPromotionDetail(promotionData){
    // go to the session detail page
    this.navCtrl.push(PromotionDetailPagePage, promotionData);

  }

  /**
   *
   * @param enterpriseShop
   */
  goToEnterprise(enterpriseShop){
    this.navCtrl.push(EnterprisePage, enterpriseShop);
  }

  hasFavorite(favoritePromotion) {
    return (this._favorites.indexOf(favoritePromotion) > -1);
  }

  /**
   *
   * @param slidingItem
   * @param promotionItem
   */
  addFavorite(slidingItem: ItemSliding, promotionItem) {

    if (this.hasFavorite(promotionItem)) {
      // woops, they already favorited it! What shall we do!?
      // prompt them to remove it
      this.removeFavorite(slidingItem, promotionItem, 'Cette promotion existe déja dans vos favorites');

    } else {
      // remember this session as a user favorite

      // create an alert instance
      let alert = this.alertCtrl.create({
        title: 'Promotion ajoutée',
        buttons: [{
          text: 'OK',
          handler: () => {
            // close the sliding item
            //console.log("ajout", promotionItem);
            this.addItemFavorite(promotionItem);
            slidingItem.close();
          }
        }]
      });
      // now present the alert on top of all other content
      alert.present();
    }

  }

  /**
   *
   * @param itemFavorite
   */
  addItemFavorite(itemFavorite) {
    this.fav.create(itemFavorite['dataPromotion']['category'].id);
    this.ent.create(itemFavorite['dataPromotion']['entreprise'].id);
    this._favorites.push(itemFavorite);
  }

  /**
   *
   * @param slidingItem
   * @param _favoritesItem
   * @param title
   */
  removeFavorite(slidingItem: ItemSliding,_favoritesItem,title) {

    let alert = this.alertCtrl.create({
      title: title,
      message: 'Voulez-vous supprimez cette promotion?',
      buttons: [
        {
          text: 'Annuler',
          handler: () => {
            // they clicked the cancel button, do not remove the favourite
            // close the sliding item and hide the option buttons
            slidingItem.close();
          }
        },
        {
          text: 'Supprimer',
          handler: () => {
            let index = this._favorites.indexOf(_favoritesItem);
            if (index > -1) {
              this._favorites.splice(index, 1);
              this.fav.remove(_favoritesItem['dataPromotion']['category'].id);
              this.ent.remove(_favoritesItem['dataPromotion']['entreprise'].id);
            }
            // close the sliding item and hide the option buttons
            slidingItem.close();
          }
        }
      ]
    });
    // now present the alert on top of all other content
    alert.present();
  }

}
