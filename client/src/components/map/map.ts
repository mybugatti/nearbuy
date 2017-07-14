import {Directive, ElementRef, Input, Renderer} from '@angular/core';
import {MapProvider} from "../../providers/map-provider";

/*
  Generated class for the Map directive.

  See https://angular.io/docs/ts/latest/api/core/index/DirectiveMetadata-class.html
  for more info on Angular 2 Directives.
*/
@Directive({
  selector: '[map]' // Attribute selector
})
export class Map {

  @Input() map;
  coordinates;

  /**
   *
   * @param element
   * @param renderer
   */
  constructor(public element: ElementRef, public renderer: Renderer, public maps: MapProvider) {}

  ngOnInit(){
    this.renderer.setElementAttribute(this.element.nativeElement, 'id', 'map');
    this.maps.init(this.element);
  }

  /**
   *
   * @returns {Promise<T>|Promise}
   */
  getItinerary(lat,lng, color){

    return new Promise((resolve, reject) => {
      this.maps.distance(this.element,lat,lng, color).then((res) => {
        this.coordinates = res;
        resolve(this.coordinates);
      }, (err)=>{
        console.log("error");
      });
    });
  }

}
