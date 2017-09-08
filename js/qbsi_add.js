<script>
var sort_by = function(field, reverse, primer){

   var key = primer ?
       function(x) {return primer(x[field])} :
       function(x) {return x[field]};

   reverse = !reverse ? 1 : -1;

   return function (a, b) {
       return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
     }
}

function getQBSI(caller) {
    var data=[];
    var newHTML=[];

    $.ajax({
          url :"json/qbsi_add.php",
          type: "post",
          datatype:'JSON',
          data:{
            type:caller
          },
          success:function(data){
//            alert ('caller - '+caller+' - data '+data);
            var qbsi_dir=[]; var qbsi_file=[];
            var keynm=[];
            if (data.length) {
              qbsi_data=JSON.parse(data);

              for (keys in qbsi_data){        // split the returned data into either qbsi_dir or qbsi_file
                knm=qbsi_data[keys];
                ddd=keys.indexOf("F");
                if (ddd<1) {
                  dirno=keys;
                  qbsi_dir.push({dirno,knm});
                } else {
                  dirnm=keys.indexOf("F");
                  dirno=keys.substr(dirnm);
                  qbsi_file.push({dirno,knm});
                }
              }
            }
            qbsi_dir=qbsi_dir.sort(sort_by('dirno',false,String));
            qbsi_file=qbsi_file.sort(sort_by('dirno',false,String));
            innerhtm="";
            for (keys in qbsi_dir) {
              accdno=qbsi_dir[keys].dirno.substr(3);
              accno="acc"+accdno; accnop="accp"+accdno;
              accname=qbsi_dir[keys].knm;
              innerhtm+='<tr><td><button type="button" class="accordian" id="'+accno+'">'+accname+'</button>';
              innerhtm+='<div class="accpanel" id="'+accnop+'">';
              for (fkeys in qbsi_file) {
                fccdno=qbsi_file[fkeys].dirno.substr(1,2);
                if (fccdno==accdno) {
                  fccno="F"+fccdno;
                  fccname=qbsi_file[fkeys].knm;
                  fccdnop=qbsi_file[fkeys].dirno.substr(1);
                  if (fccdnop.substr(0,1)=='0') fccdnop=fccdnop.substr(1);
                  innerhtm+="<img onclick='addQBSIrisk(&#39;"+caller+"&#39;,&#39;"+fccdnop+"&#39;)'src='resource/send2.png' width=20><a href='https://kids.kennedyscouts.org.au/index.php/s/1Y0xf4JNjQEBTiV/download?path=%2F"+encodeURIComponent(accname)+"&files="+fccname+"';>"+fccname+"</a><br>";
                }
              }
              innerhtm+='</div></td></tr>';
            }
            document.getElementById('qbsipanel').innerHTML=innerhtm;
            var acc = document.getElementsByClassName("accordian");
            var i;
            for (i = 0; i < acc.length; i++) {
              acc[i].onclick = function(){
                this.classList.toggle("active");
                /* Toggle between hiding and showing the active panel */
                var panel = this.nextElementSibling;
                if (panel.style.display === "inline-block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "inline-block";
                }
              }
            }
          },
          error: function(jqXHR,error, errorThrown) {
               if(jqXHR.status&&jqXHR.status==400){
                    alert(jqXHR.responseText);
               }else{
                   alert("Something went wrong");
               }
          }
      });
    }

    function getPR(caller) {
        var data=[];
        var newHTML=[];

        $.ajax({
              url :"json/pr_add.php",
              type: "post",
              datatype:'JSON',
              data:{
                type:caller
              },
              success:function(data){
//                alert(data);
                var pol_dir=[]; var pol_file=[];
                var rul_dir=[]; var rul_file=[];
                var keynm=[];
                if (data.length) {
                  qbsi_data=JSON.parse(data);

                  for (keys in qbsi_data){        // split the returned data into either policy or rules, then pol or rul_dir or _file

                    knm=qbsi_data[keys];
                    ddd=keys.indexOf("F");
                    if (ddd<1) {
                      dirno=keys;
                      pol_dir.push({dirno,knm});
                    } else {
                      dirnm=keys.indexOf("F");
                      dirno=keys.substr(dirnm);
                      pol_file.push({dirno,knm});
                    }
                  }
                }
                qbsi_dir=pol_dir.sort(sort_by('dirno',false,String));
                qbsi_file=pol_file.sort(sort_by('dirno',false,String));
                innerhtm="";
                for (keys in pol_dir) {
                  accdno=pol_dir[keys].dirno.substr(3);
                  accno="acc"+accdno; accnop="accp"+accdno;
                  accname=pol_dir[keys].knm;
                  innerhtm+='<tr><td><button type="button" class="accordian" id="'+accno+'">'+accname+'</button>';
                  innerhtm+='<div class="accpanel" id="'+accnop+'">';
                  for (fkeys in pol_file) {
                    fccdno=pol_file[fkeys].dirno.substr(1,2);
                    if (fccdno==accdno) {
                      fccno="F"+fccdno;
                      fccname=pol_file[fkeys].knm;
                      fccdnop=pol_file[fkeys].dirno.substr(1);
                      if (fccdnop.substr(0,1)=='0') fccdnop=fccdnop.substr(1);
                      innerhtm+="<img onclick='addPRrisk(&#39;"+caller+"&#39;,&#39;"+fccdnop+"&#39;)'src='resource/send2.png' width=20><a href='https://kids.kennedyscouts.org.au/index.php/s/1Y0xf4JNjQEBTiV/download?path=%2F"+encodeURIComponent(accname)+"&files="+fccname+"';>"+fccname+"</a><br>";
                    }
                  }
                  innerhtm+='</div></td></tr>';
                }
                document.getElementById('prpanel').innerHTML=innerhtm;
                var acc = document.getElementsByClassName("accordian");
                var i;
                for (i = 0; i < acc.length; i++) {
                  acc[i].onclick = function(){
                    this.classList.toggle("active");
                    /* Toggle between hiding and showing the active panel */
                    var panel = this.nextElementSibling;
                    if (panel.style.display === "inline-block") {
                        panel.style.display = "none";
                    } else {
                        panel.style.display = "inline-block";
                    }
                  }
                }
              },
              error: function(jqXHR,error, errorThrown) {
                   if(jqXHR.status&&jqXHR.status==400){
                        alert(jqXHR.responseText);
                   }else{
                       alert("poladd: Something went wrong");
                   }
              }
          });
        }
</script>
