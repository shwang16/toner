import { Component } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'Edit Toner';
  authors = "Shirley Wang and Lindsay Park";
  constructor(private http: HttpClient, private router: ActivatedRoute){ }
  tones = [];
  highlighted = 1;
  pad = [];
  user = '2';
  clicked : boolean = false;
  ngOnInit(){
    this.router.queryParams.subscribe(params => {
      this.user = params['user'];
      //console.log(this.user);
      this.http.get('http://localhost/toner/func.php?call=tones&user=' + this.user)
      .subscribe((data) => {
        //console.log(data);
        //console.log('Response', data);
        this.tones.push(data);
      }, (error) => {
        console.log('Error', error);
      })

      this.http.get('http://localhost/toner/func.php?call=pad&user='+this.user)
      .subscribe((data) => {
      //console.log('Response');
      for(let thing in data){
      this.pad.push(data[thing]);
      }
      }, (error) => {
      console.log('Error', error);
      })
    });
    //this.clicked = false;

  }

  updatePad(id){
    let params = {'update_tone': this.highlighted, 'tone_id': id};
    this.http.post('http://localhost/toner/update.php?call=pad&user='+this.user, params)
    .subscribe((data) => {
      //console.log('Response', data);
      location.reload();
    }, (error) => {
      console.log('Error', error);
    })
  }

  select(buttonID){
    this.highlighted = buttonID;
  }

  addTone(){
    this.clicked = true;
  }

}
