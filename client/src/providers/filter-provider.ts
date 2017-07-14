import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';
import {PromotionService} from "../app/services/promotion.service";
import {CategoryService} from "../app/services/category.service";

/*
  Generated class for the FilterProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class FilterProvider {

  data: any;
  dataPromotion: any;

  constructor(public http: Http, public promotion: PromotionService, public category: CategoryService) {
    console.log('Hello FilterProvider Provider');
  }

  loadCategory() {

    if (this.data) {
      // already loaded data
      return Promise.resolve(this.data);
    }

    return new Promise(resolve => {

      this.category.getCategories().then((data) => {
          this.data = data
          resolve(this.data);
      });

    });
  }
}
