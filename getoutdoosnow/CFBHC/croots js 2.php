var $row = $(obj);
      var nameStr = $row.find('td:eq(1)').text().replace(/(\r\n\t|\n|\r\t)/gm,"").trim();
    
      if(nameStr != "")
      {
        var nameSplit = nameStr.split(" ");
        var name = nameSplit[0] + " " + nameSplit[1];
    
        var offersSplit = $row.find('td:eq(7) img:eq(0)').attr('src').split("/");
        var offers = offersSplit[offersSplit.length-1].replace(".gif","");
    
         var thisrow = {
            name:   name,
            offers:          offers,
            //position:    $row.find('td:eq(2)').text().replace(/(\r\n\t|\n|\r\t)/gm,"").trim(),
            //year:       $row.find('td:eq(3)').text().replace(/(\r\n\t|\n|\r\t)/gm,"").trim(),
            //hgt:         $row.find('td:eq(4)').text().replace(/(\r\n\t|\n|\r\t)/gm,"").trim(),
            //wgt:        $row.find('td:eq(5)').text().replace(/(\r\n\t|\n|\r\t)/gm,"").trim(),
            //rating:          $row.find('td:eq(6)').text().replace(/(\r\n\t|\n|\r\t)/gm,"").trim()
            
          };
            
            rows.push(thisrow);
       }
       
       
var positions = ["QB","RB"];

var rows = [];

$.each(positions, function( index, value ) {
  console.log("value "+value);
    $.get('http://cfbhc.herokuapp.com/cfbhc/recruits/'+value+'/', function(res) {
      var data = $.parseHTML(res)
      $(data).find('tbody tr').each(function(i, obj) {
        var $row = $(obj);
        
        var nameStr = $row.find('td:eq(1)').text().replace(/(\r\n\t|\n|\r\t)/gm,"").trim();
    
          if(nameStr != "")
          {
            var nameSplit = nameStr.split(" ");
            var name = nameSplit[0] + " " + nameSplit[1];
            
            var offers = "";
            if($row.find('td:eq(7) img:eq(0)').attr('src') != "")
            {
              var offersSplit = $row.find('td:eq(7) img:eq(0)').attr('src').split("/");
              var offers = offersSplit[offersSplit.length-1].replace(".gif","");
            }
            
             var thisrow = {
                name:   name,
                offers:          offers,
              };
                
                rows.push(thisrow);
           }
        
           //console.log(thisrow);
           console.log(JSON.stringify(thisrow));
      });
     
    });
 });
 
 
 
 console.log(JSON.stringify(rows));
 console.log(rows.length);