function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var places = ["Abhaipur Behlolpur","Achna","Adaun","Ahmedpur","Ahraula","Aidalpur","Aisi","Akrabad","Akrawat","Alampur Fatehpur","Alampur Rani Barla","Aligarh City","Aligarh Dairy Farm","Aligarh","Aligarh Muslim University","Allahdadpur Aisi","Ama Madapur","Amrauli","Amritpur","Andla","Arrana","Asroi","Atrauli Ro R.S.","Atrauli","Badesara","Badhari Bujurg","Badholi","Badon","Bahadurpur Kota","Bain Kalan","Bajauta","Balwant Nagaria","Bamani","Bamnoi","Bamoti","Bankner","Bannadevi","Baranadi","Baraula","Barauli","Barla","Barotha","Basai Kazi","Beethna","Beharipur","Bembirpur","Bena","Beswan","Bhadesi","Bhagatpur","Bhaiyan","Bhamora Kalan","Bhangra","Bhankri Ahiwasi","Bhankri Niranjankot","Bharatpur","Bharpur","Bhavigarh","Bhemti","Bhikampur","Bhilet Ramnagar","Bhimpur","Bhojpur Nuri","Bidirka","Bijaigarh","Bijauli","Bilona Chitsari","Birpura","Bisara","Bistauli","Bonai","Budha Gaon","Budhansi","Chakathal","Chandaiya","Chandaua Goverdhanapur","Chandaus","Chandpur Mirza","Changeri","Chhabilpur","Chhadawali","Chhaichhau","Chhalesar","Chharra","Chherat","Chhonk","Chilawati","Civil Court","D S College","Dabha","Dadon","Daheli","Datawali","Daupur","Dayal Nagar","Debthala","Delhi Gate","Deopur","Deorau","Deta Khurd","Dewa Hamidpur","Dhanipur","Dhansari","Dhantauli","Digsari","Digsi","Dinapur","Dodhpur","Dudhma","Dunai","Fatehgarhi","Form Press","Gabhana","Gadrana","Gandhi Eye Hospital","Gangiri","Gangrol","Ganiyabali","Gehtoli Nirmal","Gharbara","Ghazipur","Gidauli","Godha","Gomat","Gonda","Gopi","Gorai","Gorola","Govindpur Fagoi","Gurusena","Gurushikharan","Habibganj","Haranpur Kalan","Harautha","Hardoi","Harduaganj","Harnaut","Hasona Jagmohanpur","Hastpur Chandfari","Hetalpur","Hinsel","I T I Road","Iglas","Iglas Thana","Industrial Area Aligarh","Ismailpur","Izzatpur","J D Singh","Jaidpura","Jaiganj","Jalali","Jalalpur","Jalalpur","Jallupur Sehore","Jalokhari","Jamaun","Jamonka","Jamuna","Jarara","Jatrauli","Jattari","Jatwar","Jawan","Jhijharka","Jirauli","Jiroli Dor","Jiroli Hira Singh","Kajrauth","Kakethal","Kalai","Kalua Bhilet","Kalwa","Kalyanpur","Kamalpur","Kandauli","Kanobi","Kanoi","Karanpur","Karanpur","Kaser","Kaseru","Kasimpur","Kasison","Kathera","Kauriyaganj","Kazimabad","Kemthal","Kesopur Jafri","Khair Mandi B.O","Khair","Khan Alampur","Khandeha","Khandua","Khera Bujurg","Khera Narain Singh","Khera Sattu","Khirsauli","Khurrampur","Kilpur","Kiratpur Nimana","Klyanpur","Komari","Konchhor","Korah Rustampur","Kutchery","Kutubour Amarpur","Ladhaua","Lehra","Lodha","Lohgarh","Lutsan","Madanpur","Madar Darwaja","Madha Habibpur","Madhaula","Madholi","Madrak","Mahavir Ganj","Mahua","Maisubhasgram","Majhola","Majupur","Malav","Malikpura","Malviya Nagar","Manai","Mandanpur","Mandpur","Manena Ummedpur","Mangalayatan University","Manik Chowk","Manti Basai","Matroi","Maur","Medical College","Mehgora","Mehrawal","Mirpur Khas","Mohkampur Garia","Mohrena","Mohreni","Mukandpur","Musepur Jalal","N C Kasimpur","Nagla Birkhu","Nagla Devi","Nagla Jagdeo","Nagla Jhujhar","Nagla Padam","Nagla Sarua","Naglamandir","Nah","Nahal","Narainpur","Narona Akapur","Narupura","Naugawan","Naurangabad B.O","Ogipur","Orani Dalpatpur","Pachawari","Pahari Pur","Pahawati","Paindapur","Pairi","Paitra Nawabpur","Pala Aisi","Pala Chand","Pala Kastali","Pali Mukimpur","Palirajapur","Palsera","Panehra","Panethi","Parki","Pempur","Phusauli","Pilkhana","Pilona","Pipari","Pipoli","Pisawah","Pothi","Pureni","Quarsi","Rait","Rajatau","Rajawal","Rajmau","Rajpur","Rajpur Khas","Ramghat Road","Ramnagar","Rampur Chandyana","Rampur Shahpur","Rani","Ranjeet Garhi","Rasal Ganj","Rehsupur","Resari","Rukhala","Sabalpur","Sadhu Ashram","Sahajpur","Sahara Khurd","Sahjahanpur Baijna","Sahnaul","Salarpur","Salempur","Salpur","Sankra","Sarai Khirni","Sarai Kutub B.O","Sarai Labaria","Sarsol","Sasni Gate B.O","Satha","Sathini","Sawai Raghunathpur","Sehri Madangarhi","Shadipur","Shahabajpur","Shahagarh","Shahpur Kutub","Shahpur Madrak","Sheikhupur","Shikharan","Shiwala","Siarol","Sikandarpur Kota","Sikharna","Sikur","Simardhari","Simrauthi","Siroli","Siya Khas","Somna","Songra","Subhash Road","Sudama Ka Bas","Sudeshpur","Suhawali","Sujanpur","Sumera","Sunamai","Sunpahar","T R M M Aligarh","Takipura","Talesara","Talib Nagar","Tamkoli","Tamotia","Tappal","Tatarpur","Teothu","Tuamai","Udaipur","Ukhlana","Umri","Untasani","Upperkot","Usram","Utra","Utwara","Vishnupuri","Zafar Manzil"];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("searchPlaces"), places);