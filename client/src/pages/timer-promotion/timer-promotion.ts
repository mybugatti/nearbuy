import {Component, Input} from '@angular/core';
import {ITimer} from "./timer-interface";

/*
  Generated class for the TimerPromotion page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'timer',
  templateUrl: 'timer-promotion.html'
})
export class TimerPromotionPage {

  @Input() timeInSeconds: number;
  public timer: ITimer;

  constructor() {}

  ngOnInit() {
    this.initTimer();
  }

  hasFinished() {
    return this.timer.hasFinished;
  }

  initTimer() {
    if(!this.timeInSeconds) { this.timeInSeconds = 0; }

    this.timer = <ITimer>{
      seconds: this.timeInSeconds,
      runTimer: false,
      hasStarted: false,
      hasFinished: false,
      secondsRemaining: this.timeInSeconds
    };

    this.timer.displayTime = this.getSecondsAsDigitalClock(this.timer.secondsRemaining);
  }

  startTimer() {
    this.timer.hasStarted = true;
    this.timer.runTimer = true;
    this.timerTick();
  }

  pauseTimer() {
    this.timer.runTimer = false;
  }

  resumeTimer() {
    this.startTimer();
  }

  timerTick() {
    setTimeout(() => {
      if (!this.timer.runTimer) { return; }
      this.timer.secondsRemaining--;
      this.timer.displayTime = this.getSecondsAsDigitalClock(this.timer.secondsRemaining);
      if (this.timer.secondsRemaining > 0) {
        this.timerTick();
      }
      else {
        this.timer.hasFinished = true;
      }
    }, 1000);
  }

  getSecondsAsDigitalClock(inputSeconds: number) {
    var sec_num = parseInt(inputSeconds.toString(), 10); // don't forget the second param
    /*
    var hours = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);
    var day = Math.floor(hours / 24); */

    var day = Math.floor(sec_num / 86400);
    var resteday = (sec_num % 86400);
    var hours = Math.floor(resteday / 3600);
    var restehours = (resteday % 3600);
    var minutes = Math.floor(restehours / 60);
    var resteminutes = (restehours%60);
    var seconds = resteminutes;

    var dayString = '';
    var hoursString = '';
    var minutesString = '';
    var secondsString = '';
    dayString =  (day < 10) ? "0" + day : day.toString();
    hoursString = (hours < 10) ? "0" + hours : hours.toString();
    minutesString = (minutes < 10) ? "0" + minutes : minutes.toString();
    secondsString = (seconds < 10) ? "0" + seconds : seconds.toString();
    return dayString +'j ' + hoursString + 'h ' + minutesString + 'm ' + secondsString + ' s';
  }

  getTimeRemaining(endtime){
    var t = Date.parse(endtime) - Date.parse(endtime);
    var seconds = Math.floor( (t/1000) % 60 );
    var minutes = Math.floor( (t/1000/60) % 60 );
    var hours = Math.floor( (t/(1000*60*60)) % 24 );
    var days = Math.floor( t/(1000*60*60*24) );
    return {
      'total': t,
      'days': days,
      'hours': hours,
      'minutes': minutes,
      'seconds': seconds
    };
  }

}
