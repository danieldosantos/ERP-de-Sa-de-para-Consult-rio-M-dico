var l,r=0;addEventListener("message",({data:e})=>{if(e&&e.serverTime){let s=new Date(e.serverTime);clearInterval(l),e.idle||(l=setInterval(()=>{s.setMilliseconds(s.getMilliseconds()+1e3),r>600&&!e.idle?(postMessage({serverTime:s,refresh:!0}),r=0):(postMessage({serverTime:s,refresh:!1}),r++)},1e3))}});
/**i18n:de94916d77c020799d465cef81d542a7dba531be1c77bfaecdd5d4f09189bc8d*/
