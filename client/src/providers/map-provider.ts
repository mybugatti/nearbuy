import {Injectable} from '@angular/core';
import {Geolocation} from 'ionic-native';
import {Http} from '@angular/http';
import 'rxjs/add/operator/map';
import {LocalService} from "../app/services/local.service";
import {addToArray} from "@angular/core/src/linker/view_utils";
import {PromotionService} from "../app/services/promotion.service";
import {CategoryService} from "../app/services/category.service";


declare var google;
/*
 Generated class for the MapProvider provider.

 See https://angular.io/docs/ts/latest/guide/dependency-injection.html
 for more info on providers and Angular 2 DI.
 */
@Injectable()
export class MapProvider {

  map: any; // variable google map
  mapElement: any;
  mapInitialised: boolean = false;
  markers: any = [];

  public address: any;

  /**
   *
   * @param http
   * @param local
   * @param promotion
   */
  constructor(public http: Http,
              public local: LocalService,
              public promotion: PromotionService,
              public category: CategoryService) {
  }

  /**
   *
   * @param mapElement
   * @returns {Promise<any>}
   */
  init(mapElement: any): Promise<any> {

    this.mapElement = mapElement.nativeElement;
    return this.loadGoogleMaps();

  }

  /**
   *
   * @returns {Promise<T>|Promise}
   */
  loadGoogleMaps(): Promise<any> {

    return new Promise((resolve) => {

      if (typeof google == "undefined" || typeof google.maps == "undefined") {

        console.log("Google maps JavaScript needs to be loaded.");

      }
      else {

        this.initMap();

      }

    });

  }

  /**
   *
   * @returns {Promise<T>|Promise}
   */
  initMap() {

    this.mapInitialised = true;

    return new Promise((resolve) => {

      Geolocation.getCurrentPosition().then((position) => {

        let latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

        let mapOptions = {
          center: latLng,
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }

        this.map = new google.maps.Map(this.mapElement, mapOptions);

        google.maps.event.addListenerOnce(this.map, 'idle', () => {

          this.loadMarkers();

          google.maps.event.addListener(this.map, 'dragend', () => {
          });

        });
        resolve(true);

      });

    });

  }

  /**
   *
   */
  loadMarkers() {

    let center = this.map.getCenter();

    // Convert to readable format
    let currentPosition = {
      lat: center.lat(),
      lng: center.lng()
    };

    let sortedplace = [];

    new google.maps.Marker({
      map: this.map,
      position: currentPosition
    });

    return new Promise((resolve) => {

      this.promotion.getPromotions().then((data) => {

        // other locations
        this.local.getLocals().then((dataLocal) => {

          dataLocal.forEach((location) => {

            let placeLocation = {
              lat: location['lat'],
              lng: location['lng']
            };

            let boundingRadius = this.getBoundingRadius(currentPosition, placeLocation); // current position and other positions

            let localwithDist = {
              lng: currentPosition.lng,
              lat: currentPosition.lat,
              maxDistance: boundingRadius,
              placeLocation: placeLocation,
              dataPromotion: data,
              dataLocal: dataLocal
            }

            addToArray(localwithDist, sortedplace);

          });

          sortedplace.sort((x, y)=> {
            return x.maxDistance - y.maxDistance;
          });

          let markerLocaux = dataLocal;
          let dataPromotion = data;

          this.addMarkers(markerLocaux, dataPromotion);

          resolve(sortedplace);

        });

      });

    });
  }

  /**
   *
   * @param markers
   * @param colors
   */
  addMarkers(markers, data) {

    let markerLatLng;
    let lat;
    let lng;
    let schedule;
    let address;
    let name;
    let tabColor = [];
    let tabEntreprise = [];

    data.forEach((dataPromotion) => {

      if (tabColor.indexOf(dataPromotion['category'].color) < 0) {
        tabColor.push(dataPromotion['category'].color);
      }

      if (tabEntreprise.indexOf(dataPromotion['entreprise'].name) < 0) {
        tabEntreprise.push(dataPromotion['entreprise'].name);
      }

    });

    markers.forEach((marker, index) => {

      lat = marker['lat'];
      lng = marker['lng'];
      schedule = marker['schedule'];
      address = marker['address'];
      name = tabEntreprise[index];

      markerLatLng = new google.maps.LatLng(lat, lng);

      if (this.markerExists(lat, lng)) {
        let marker = new google.maps.Marker({
          map: this.map,
          animation: google.maps.Animation.BOUNCE,
          icon: this.getMarkerIcon(tabColor[index]),
          position: markerLatLng
        });

        let markerData = {
          lat: lat,
          lng: lng,
          marker: marker
        };

        this.markers.push(markerData);
        this.addInfoWindow(marker, schedule, address, name);

      }

    });

  }

  /**
   *
   * @param markers
   * @param schedule
   * @param address
   * @param name
   * @param distance
   */
  addInfoWindow(markers, schedule, address, name) {

    let infoWindow = new google.maps.InfoWindow({
      content: ""
    });

    google.maps.event.addListener(markers, 'click', () => {
      infoWindow.setContent(
        '<div class="infoWindow">' +
        '<p class="infoWindow_home">' + name + '</p>' +
        '<p class="infoWindow_pin">' + address + '</p>' +
        '<p class="infoWindow_calendar">' + schedule + '</p>' +
        '<button class="infoWindow_btn" (click)="goToEnterprise()">En savoir plus</button>' +
        '</div>');

      infoWindow.open(this.map, markers);
    });

  }

  /**
   *
   * @param lat
   * @param lng
   * @returns {boolean}
   */
  markerExists(lat, lng) {
    let exists = true;

    this.markers.forEach((marker) => {
      if (marker.lat === lat && marker.lng === lng) {
        exists = true;
      }
    });

    return exists;

  }

  /**
   *
   * @param center
   * @param bounds
   * @returns {number}
   */
  getBoundingRadius(center, bounds) {
    return this.getDistanceBetweenPoints(center, bounds, 'km').toFixed(2);
  }

  /**
   *
   * @param start
   * @param end
   * @param units
   * @returns {number}
   */
  getDistanceBetweenPoints(start, end, units) {

    let earthRadius = {
      miles: 3958.8,
      km: 6371
    };

    let R = earthRadius[units || 'miles'];
    let lat1 = start.lat;
    let lon1 = start.lng;
    let lat2 = end.lat;
    let lon2 = end.lng;

    let dLat = this.toRad((lat2 - lat1));
    let dLon = this.toRad((lon2 - lon1));
    let a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(this.toRad(lat1)) * Math.cos(this.toRad(lat2)) *
      Math.sin(dLon / 2) *
      Math.sin(dLon / 2);
    let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    let d = R * c;

    return d;

  }

  /**
   *
   * @param x
   * @returns {number}
   */
  toRad(x) {
    return x * Math.PI / 180;
  }

  /**
   *
   * @param color
   * @returns {{url: string, size: google.maps.Size, origin: google.maps.Point, anchor: google.maps.Point}}
   */
  getMarkerIcon(color) {
    let svgString = `<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
       width="32px" height="54,526504174px" viewBox="0 0 149.75 255.167" xml:space="preserve">
      <path id="plain" fill="` + color + `" d="M149.75,74.875C149.75,33.523,116.227,0,74.875,0S0,33.523,0,74.875c0,12.926,3.275,25.086,9.041,35.698
        C32.5,156.167,66.5,194,69.966,248.689c0.137,2.162,0.367,6.479,4.909,6.479c4.542,0,4.772-4.316,4.909-6.479
        C83.25,194,117.25,156.167,140.709,110.573C146.475,99.961,149.75,87.801,149.75,74.875"/>
      <g opacity="0.1">
        <path fill="#000000" d="M149.73,74.105c-0.201,12.466-3.44,24.194-9.022,34.468
          c-23.459,45.594-57.459,83.428-60.925,138.116c-0.137,2.162-0.367,6.479-4.909,6.479c-4.541,0-4.771-4.316-4.908-6.479
          c-3.467-54.688-37.467-92.521-60.925-138.116C3.459,98.299,0.22,86.571,0.019,74.105c-0.003,0.258-0.02,0.512-0.02,0.77
          c0,12.926,3.276,25.086,9.042,35.698C32.499,156.167,66.499,194,69.966,248.689c0.137,2.162,0.367,6.479,4.908,6.479
          c4.542,0,4.772-4.316,4.909-6.479c3.466-54.689,37.466-92.521,60.925-138.116c5.767-10.612,9.041-22.772,9.041-35.698
          C149.749,74.617,149.733,74.363,149.73,74.105"/>
      </g>
      <g opacity="0.15">
        <path  fill="#FFFFFF" d="M74.875,2c41.094,0,74.44,33.109,74.856,74.105
          c0.006-0.41,0.02-0.818,0.02-1.23C149.75,33.523,116.227,0,74.875,0S0,33.523,0,74.875c0,0.412,0.013,0.82,0.019,1.23
          C0.435,35.109,33.781,2,74.875,2"/>
      </g>
      <g id="pourcent">
        <path fill="#FFF" d="M99.623,93.749c3.309,0,6,2.692,6,6s-2.691,6-6,6c-3.308,0-6-2.692-6-6S96.315,93.749,99.623,93.749
         M99.623,81.749c-9.94,0-18,8.059-18,18s8.06,18,18,18c9.941,0,18-8.059,18-18S109.564,81.749,99.623,81.749"/>
        <path fill="#FFF" d="M50.126,44.251c3.308,0,6,2.692,6,6s-2.692,6-6,6s-6-2.692-6-6S46.818,44.251,50.126,44.251 M50.126,32.251
          c-9.941,0-18,8.059-18,18s8.059,18,18,18s18-8.059,18-18S60.067,32.251,50.126,32.251"/>
        <rect x="68.999" y="25.001" transform="matrix(0.7071 0.7071 -0.7071 0.7071 75.0001 -31.0654)" fill="#FFF" width="12" height="99.999"/>
      </g>
    </svg>`;

    let b64icon = btoa(svgString);


    return {
      url: 'data:image/svg+xml;base64,' + b64icon,
      size: new google.maps.Size(32, 55),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(16, 55)
    };
  }

  /**
   *
   * @param element
   * @param destination
   * @returns {Promise<T>|Promise}
   */
  distance(element, lat, lng, color) {

    var color: any = this.getMarkerIcon(color);

    return new Promise(function (resolve, reject) {

      Geolocation.getCurrentPosition().then((position) => {

        var directionsService = new google.maps.DirectionsService; // Service de calcul d'itinéraire

        let latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        let destination = new google.maps.LatLng(lat, lng);

        let request = {
          origin: latLng,
          destination: destination,
          travelMode: google.maps.TravelMode.DRIVING
        };

        let mapOptions = {
          center: latLng,
          zoom: 16,
          mapTypeId: google.maps.MapTypeId.ROADMAP // Type de transport
        };

        let map = new google.maps.Map(element.nativeElement, mapOptions);

        var rendererOptions = {
          map: map,
          suppressMarkers: true
        }

        var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

        directionsDisplay.setMap(map);

        // Envoie de la requête pour calculer le parcours
        directionsService.route(request, function (response, status) {

          if (status === google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);

            var myRoute = response.routes[0].legs[0];

            for (var i = 0; i < myRoute.steps.length; i++) {

              if (i == 0) {
                // Icon as start position
                var marker = new google.maps.Marker({
                  position: myRoute.steps[i].start_point,
                  map: map,
                  icon: "https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=|FF0000|000000"
                });
              }

            }
            // Icon as end position
            var marker = new google.maps.Marker({
              position: myRoute.steps[i - 1].end_point,
              map: map,
              icon: color
            });

            resolve(response);

          } else {
            console.log('failed' + status);
          }
        });

      }, (err) => {
        console.log('Bad Request');
      });
    });
  }


  loadLocations() {

    return new Promise((resolve) => {

      Geolocation.getCurrentPosition().then((position) => {

        // Convert to readable format
        let currentPosition = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };

        new google.maps.Marker({
          map: this.map,
          position: currentPosition
        });

        let sortedplace = [];

        this.promotion.getPromotions().then((data) => {

          data.map((dataPromotion) => {

            // other locations
            this.local.getLocals().then((dataLocal) => {

              dataLocal.forEach((location, index) => {

                if (location['entreprise'].id === dataPromotion['entreprise'].id) {

                  let placeLocation = {
                    lat: location['lat'],
                    lng: location['lng']
                  };

                  let boundingRadius = this.getBoundingRadius(currentPosition, placeLocation); // current position and other positions

                  let localwithDist = {
                    lng: currentPosition.lng,
                    lat: currentPosition.lat,
                    maxDistance: boundingRadius,
                    placeLocation: placeLocation,
                    dataPromotion: dataPromotion,
                    dataLocal: dataLocal[index]
                  }

                  addToArray(localwithDist, sortedplace);

                }

              });

              sortedplace.sort((x, y)=> {
                return x.maxDistance - y.maxDistance;
              });

            });

          });

          resolve(sortedplace);

        });

      });

    });
  }

}
