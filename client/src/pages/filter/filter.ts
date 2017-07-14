import { Component } from '@angular/core';
import { NavParams, ViewController} from 'ionic-angular';
import {FilterProvider} from "../../providers/filter-provider";

/*
  Generated class for the Filter page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-filter',
  templateUrl: 'filter.html'
})
export class FilterPage {

  promotionCategory: Array<{name: string, isChecked: boolean}> = [];
  category: any;

  constructor(public navParams: NavParams, public viewCtrl: ViewController, public filter: FilterProvider) {
    // passed in array of track names that should be excluded (unchecked)
    let excludedTrackNames = this.navParams.data;

    this.filter.loadCategory().then((data) => {

      this.category = data;

      data.forEach(dataCategory => {
          this.promotionCategory.push({
            name: dataCategory.name,
            isChecked: (excludedTrackNames.indexOf(dataCategory.name) === -1)
          });

      });
    }, (err) => {
      console.log("error", err);
    });

  }

  resetFilters() {
    // reset all of the toggles to be checked
    this.promotionCategory.forEach(category => {
      category.isChecked = true;
    });
  }

  applyFilters() {

    // Pass back a new array of track names to exclude
    let excludedTrackNames = this.promotionCategory.filter(c => !c.isChecked).map(c => c.name);
    this.dismiss(excludedTrackNames, this.category);
  }

  dismiss(data?: any, dataC?:any) {
    // using the injected ViewController this page
    // can "dismiss" itself and pass back data
    this.viewCtrl.dismiss(data,dataC);
  }
}
