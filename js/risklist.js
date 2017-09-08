<script>
// receive POST data - 1st item is type of query V=program, T=Act Class, S=site, C=C5 (into)
//                     2nd item is RiskID (riskid)
//                     3rd item is TypeID - ID from V, T, S or C (typeID)
//										 4th is siteid
//										 5th is AAPid
//                     6th is 0 for read, 1 for insert, 3 for delete (readit)
//										 7th is for risk name (name)

function getrisk(type,riskid,typeid,siteid,AAPid,readit,name) {
  var rghts=<?php Print($rights); ?>;
  if ((rghts==0 && readit==0)|| (rghts==1)) {
    var data=[];
    var newHTML=[];
//    alert ('fields are - '+type+', '+riskid+', '+typeid+', '+siteid+', '+AAPid+', '+readit+', '+name+'');
    if (type==undefined) {typeid='V';};

    $.ajax({
          url :"json/riskresp.php",
          type: "post",
          datatype:'JSON',
          data:{
            into:type,
            riskid:riskid,
            typeid:typeid,
            siteid:siteid,
            AAPid:AAPid,
            readit:readit,
            name:name,
          },
          success:function(data){
//            alert ('type - '+type+' - riskid - '+riskid+' - typeid - '+typeid+' - siteid - '+siteid+' - AAPid - '+AAPid+' - readit - '+readit+' - data - '+data);
            if (jQuery.parseJSON(data).length) {
              if (document.querySelector('#idAAP')==null) {evnt=0;} else {evnt=1;}
              if (readit==0||readit==2) {                                // show risks for this activity type
                referto=0;                                               // used to show refer to branch or region top of risk list in F31
                newHTML='<tr><th style="width:350px;">Risk Name</th><th style="width:180px;">Before</th><th class="tabicon";>Del</th></tr>';
                if (type=='V') {newHTML='<tr><th style="width:210px;">Risk Name</th><th style="width:190px;">Task</th><th style="width:190px;">Risk</th><th style="width:60px;">Before</th><th style="width:60px;">After</th><th style="width:80px;">Type</th><th class="tabicon";>Del</th></tr>';}
                if (type=='C' || evnt==1) {newHTML='<tr><th style="width:190px;">Risk Name</th><th style="width:190px;">Task</th><th style="width:190px;">Risk</th><th style="width:60px;">Before</th><th style="width:60px;">After</th><th style="width:80px;">Type</th><th class="tabicon";>Del</th></tr>';}
                $(jQuery.parseJSON(data)).each(function() {
//                    newHTML+="<tr><td>"+this.risk_name+"</td></tr>";
                    new2HTML=newHTML+("<tr><td style='text-align:left'><a href='javascript:void(0)' onclick='prepRisk("+this.idrisk+")'");
                    newHTML+=("<tr><td style='text-align:left'><a href='index.php?pg=risk_edit&id="+this.idrisk+"&scr=");

                    if (type=='V') {newHTML=new2HTML+(">"+this.risk_name+"</a></td><td style='text-align:left'>"+this.task+"</td><td style='text-align:left'>"+this.risk+"</td><td");}
                    if (type=='T' || type=='S') {newHTML=new2HTML+(">"+this.risk_name+"</a></td><td");}
                    if (type=='C' || evnt==1) {newHTML=new2HTML+(">"+this.risk_name+"</a></td><td>"+this.task+"</td><td>"+this.risk+"</td><td");}
                    colr=this.matrix_before.substr(0,1);
                    if (colr=='L') {newHTML+=(" style='background-color:green' ")};
                    if (colr=='M') {newHTML+=(" style='background-color:yellow' ")};
                    if (colr=='H') {newHTML+=(" style='background-color:orange' ")};
                    if (colr=='E') {newHTML+=(" style='background-color:red' ")};
                    newHTML+=(">"+this.matrix_before+"</td");
                    if (type=='C' || type=='V' || evnt==1) {
                      newHTML+=("><td");
                      colr=this.matrix_after.substr(0,1);
                      if (colr=='L') {newHTML+=(" style='background-color:green' ")};
                      if (colr=='M') {if (type=='C' && referto==0) {referto=1;} newHTML+=(" style='background-color:yellow' ")};
                      if (colr=='H') {if (type=='C') {referto=2;} newHTML+=(" style='background-color:orange' ")};
                      if (colr=='E') {if (type=='C') {referto=2;} newHTML+=(" style='background-color:red' ")};
                      newHTML+=(">"+this.matrix_after+"</td><td>"+this.risk_type+"</td");
                    }
                    newHTML+=("><td class='tabicon';><img onclick='getrisk(&#39;");
                    if (type=='V') {newHTML+=("V&#39;,&#39;"+this.idrisk+"&#39;,&#39;"+idact+"&#39;,&#39;&#39;,&#39;&#39;,&#39;3&#39;,&#39;&#39;)' src='resource/del.png' width=20></td></tr>");}
                    if (type=='S') {newHTML+=("S&#39;,&#39;"+this.idrisk+"&#39;,&#39;"+idact+"&#39;,&#39;"+this.siteid+"&#39;,&#39;&#39;,&#39;3&#39;,&#39;&#39;)' src='resource/del.png' width=20></td></tr>");}
                    if (type=='C' || evnt==1) {newHTML+=("C&#39;,&#39;"+this.idrisk+"&#39;,&#39;"+typeid+"&#39;,&#39;"+siteid+"&#39;,&#39;"+AAPid+"&#39;,&#39;3&#39;,&#39;&#39;)' src='resource/del.png' width=20></td></tr>");}
                });

                if (readit==0 && type!=='S') {if (referto==2) {$('#referto').text("Refer to Branch");} if (referto==1) {$('#referto').text("Refer to Region");} $('#rtable').html(newHTML);sorttable.makeSortable(rtable);} else {$('#rtableS').html(newHTML);sorttable.makeSortable(rtableS);}
                if (type=='C') {risklst(type,AAPid);}
                if (type=='S') {risklst(type,siteid);}
                if (type=='V') {risklst(type,typeid);}
              };
            } else {

              newHTML='<tr><td style="width:484px">Risk</td><td style="width:84px">Before</td><td class="tabicon";>Del</td></tr>';
              if (type=='S') {$('#rtableS').html(newHTML);sorttable.makeSortable(rtableS);
              risklst(type,siteid);}
            }
            if (type=='V' && (readit=='1'||readit=='3')) {
              idact=document.querySelector('#actvid').value;
              getrisk('V','0',idact,'','','0','');
            }
            if (type=='S' && (readit=='1'||readit=='3')) {
              idact=document.querySelector('#siteid').value;
              getrisk('S','0',idact,idact,'','0','');
            }
            if (type=='C' && (readit=='1'||readit=='3')) {
              idact=document.querySelector('#idAAP').value;
              getrisk('C','0',typeid,siteid,AAPid,'0','');
            }
            if ((type=='V'|| type=='S') && readit=='3') {
//              alert (jQuery.parseJSON(data));
              if (jQuery.parseJSON(data)=='[{"a":1}]') {
                newHTML='<tr><td style="width:420px;">Risk</td><td style="width:80px;">Before</td><td class="tabicon";>Del</td></tr>';
                $('#rtable').html(newHTML);
                sorttable.makeSortable(rtable);
                risklst(type,idact);
              }
            }
          },
          error: function(){
            alert ('error getrisk');
          }
      });
    }
  }

    function risklst(typ,idact) {
        var data=[];
        var newHTML=[];
        tipid=idact;
//        alert ('fields are - '+typ+', '+idact);
        $.ajax({
              url :"json/risklist.php",
              type: "post",
              datatype:'JSON',
              data:{
                typ:typ,
                typeid:idact,
              },
              success:function(data){
//              alert ("type -"+typ+" - idact - "+idact+" - tipid -"+tipid+ " - data - "+data);
                if (jQuery.parseJSON(data).length) {
                    newHTML='<tr><td>Add</td><td>Risk</td></tr>';
                    $(jQuery.parseJSON(data)).each(function() {
                      if (typ=='S') {
                        var sitid=document.querySelector('#siteid').value;
                        newHTML+=("<tr><td class='tabicon';><img onclick='getrisk(&#39;"+typ+"&#39;,&#39;"+this.idrisk+"&#39;,&#39;"+idact+"&#39;,&#39;"+sitid+"&#39;,&#39;&#39;,&#39;1&#39;,&#39;&#39;)' src='resource/send.png' width=20></td><td>"+this.risk_name+"</td></tr>");}
                      if (typ=='V') {newHTML+=("<tr><td class='tabicon';><img onclick='getrisk(&#39;"+typ+"&#39;,&#39;"+this.idrisk+"&#39;,&#39;"+tipid+"&#39;,&#39;&#39;,&#39;&#39;,&#39;1&#39;,&#39;&#39;)' src='resource/send.png' width=20></td><td>"+this.risk_name+"</td></tr>");}
                      if (typ=='C') {
                        var idact = (parseInt(document.querySelector('#C5_activ').value));
                        var sitid=(parseInt(document.querySelector('#siteid').value));
                        var AAPid=(parseInt(document.querySelector('#idAAP').value));
                        newHTML+=("<tr><td class='tabicon';><img onclick='getrisk(&#39;"+typ+"&#39;,&#39;"+this.idrisk+"&#39;,&#39;"+idact+"&#39;,&#39;"+sitid+"&#39;,&#39;"+AAPid+"&#39;,&#39;1&#39;,&#39;&#39;)' src='resource/send.png' width=20></td><td>"+this.risk_name+"</td></tr>");}

                      $('#risktable').html(newHTML);
                    });
                  };
              },
              error: function(){
                alert ('error risklist');
              }
            });
          }

</script>
