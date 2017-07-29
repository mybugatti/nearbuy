/**
 * Created by Bugatti on 29/07/2017.
 */
import { Injectable } from '@angular/core';
import { Category } from '../class/category'
import { Http } from "@angular/http";
import 'rxjs/add/operator/toPromise';
import { BaseService } from "./base.service";
import { OAuthService } from "angular-oauth2-oidc";

@Injectable()
export class CategoryService extends BaseService{
    constructor(private http: Http, oauthService: OAuthService){
        super(oauthService);
    }

    // parent function based on class name don't work after npm build so override it until abstract solution is found
    getEntityName(){
        return 'category';
    }

    getCategories(): Promise<Category[]>{
        return this.http.get(this.baseUrl +"categories", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    getCategory(id : number): Promise<Category> {
        return this.http.get(this.getEntityUrl()+"/"+id+".json", {headers: this.headers})
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    create(category : Category): Promise<Category> {
        return this.http
            .post(this.getEntityUrl(), this.serialize(category), {headers: this.headers})
            .toPromise()
            .then(res => res.json())
            .catch(this.handleError);
    }

    update(category : Category): Promise<Category>{
        const url = `${this.getEntityUrl()}/${category.id}`;
        return this.http
            .put(url, this.serialize(category), {headers: this.headers})
            .toPromise()
            .then(() => category)
            .catch(this.handleError);
    }

    remove(id : number): Promise<void> {
        const url = `${this.getEntityUrl()}/${id}`;
        return this.http.delete(url, {headers: this.headers})
            .toPromise()
            .then(() => null)
            .catch(this.handleError);
    }
}