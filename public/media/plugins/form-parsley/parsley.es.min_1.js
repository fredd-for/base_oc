/* Parsley dist/parsley.es.min.js build version 1.1.17 http://parsleyjs.org */
window.ParsleyConfig=window.ParsleyConfig||{};
(function(h){window.ParsleyConfig=h.extend(!0,{},window.ParsleyConfig,{validators:{es_dni:function(a){var d;a=a.replace("-","");a=a.toUpperCase();d=a.substring(0,a.length-1);a=a[a.length-1];return!/\d+/.test(d)||0>!"TRWAGMYFPDXBNJZSQVHLCKET".indexOf(a)?!1:a=="TRWAGMYFPDXBNJZSQVHLCKET"[parseInt(d,10)%23]},es_postalcode:function(a){if(!/^\d{5}$/.test(a))return!1;a=parseInt(a.substring(0,2),10);return 52<a||1>a?!1:!0},es_ssn:function(a){var d,c;a=a.replace(/[ \/-]/g,"");if(!/^\d{12}$/.test(a))return!1;
d=a.substring(0,2);c=a.substring(2,10);a=a.substring(10,12);d=1E7>parseInt(c,10)?parseInt(c,10)+1E7*parseInt(d,10):d+c.replace(/0*$/,"");return parseInt(d)%97===parseInt(a)},es_ccc:function(a){var d,c,b,e,f;a=a.replace(/[ -]/g,"");if(!/\d{20}$/.test(a))return!1;f=[1,2,4,8,5,10,9,7,3,6];c=a.substring(0,4);e=a.substring(4,8);d=a.substring(8,10);a=a.substr(10,20);b="00"+c+e;for(e=c=0;10>e;e++)c+=parseInt(b[e],10)*f[e];c=11-c%11;10===c&&(c=1);11===c&&(c=0);for(e=b=0;10>e;e++)b+=parseInt(a[e],10)*f[e];
b=11-b%11;10===b&&(b=1);11===b&&(b=0);return c===parseInt(d[0])&&b===parseInt(d[1])?!0:!1},es_cif:function(a){var d,c,b,e,f,g;a=a.replace(/-/g,"").toUpperCase();if(!/^[ABCDEFGHJKLMNPRQSUVW]\d{7}[\d[ABCDEFGHIJ]$/.test(a))return!1;d=a.substring(0,1);e=a.substring(1,3);b=a.substring(3,8);a=a.substring(8,9);if(/[CKLMNPQRSW]/.test(d)&&/\d/.test(a)||/[ABDEFGHJUV]/.test(d)&&/[A-Z]/.test(a))return!1;d=parseInt(e[1],10)+parseInt(b[1],10)+parseInt(b[3],10);c=0;e=[parseInt(e[0],10),parseInt(b[0],10),parseInt(b[2],
10),parseInt(b[4],10)];f=0;for(g=e.length;f<g;f++)b=e[f],b*=2,10<=b&&(b=b%10+1),c+=b;b=(d+c)%10;b=0!==b?10-b:0;return a!==b.toString()&&"JABCDEFGHI"[b]!==a?!1:!0}},messages:{es_dni:"This value should be a valid DNI (Example: 00000000T).",es_cif:"This value should be a valid CIF (Example: B00000000).",es_postalcode:"This value should be a valid spanish postal code (Example: 28080).",es_ssn:"This value should be a valid spanish social security number.",es_ccc:"This value should be a valid spanish bank client account code."}})})(window.jQuery||
window.Zepto);
