const ui=window.undoTheme||{};
const toggle=document.querySelector('.menu-toggle');
const mobileNav=document.querySelector('.mobile-nav');
toggle?.addEventListener('click',()=>{const open=toggle.getAttribute('aria-expanded')==='true';toggle.setAttribute('aria-expanded',String(!open));toggle.setAttribute('aria-label',open?ui.menuOpen:ui.menuClose);mobileNav.hidden=open});
mobileNav?.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{mobileNav.hidden=true;toggle.setAttribute('aria-expanded','false');toggle.setAttribute('aria-label',ui.menuOpen)}));
const comparison=document.querySelector('.comparison-range');
const comparisonBrowser=document.querySelector('.browser');
function updateComparison(){if(!comparison||!comparisonBrowser)return;const amount=Number(comparison.value);comparisonBrowser.style.setProperty('--split',`${amount}%`);comparisonBrowser.dataset.compare=amount<=4?'after':amount>=96?'before':'split';comparison.setAttribute('aria-valuetext',String(ui.comparisonValue||'%s%% of the earlier layout visible').replace('%s%%',amount+'%').replace('%s',amount))}
comparison?.addEventListener('input',updateComparison);
updateComparison();
document.getElementById('brief-form')?.addEventListener('submit',event=>{event.preventDefault();const data=new FormData(event.currentTarget);const name=String(data.get('projectName')||'').trim()||ui.untitled;const goal=String(data.get('goal')||'').trim()||ui.toDiscuss;const service=ui.serviceLabels?.[data.get('service')]||data.get('service');const stage=ui.stageLabels?.[data.get('stage')]||data.get('stage');const lines=[ui.briefTitle,'',`${ui.project}: ${name}`,`${ui.service}: ${service}`,`${ui.startingPoint}: ${stage}`,`${ui.goal}: ${goal}`];const body=(ui.language==='fa'?'\uFEFF':'')+lines.join('\n');const file=new Blob([body],{type:'text/plain;charset=utf-8'});const url=URL.createObjectURL(file);const link=document.createElement('a');link.href=url;link.download=ui.language==='fa'?'undo-project-brief-fa.txt':'undo-project-brief.txt';link.click();setTimeout(()=>URL.revokeObjectURL(url),1000);document.getElementById('form-status').textContent=ui.downloaded});
const sectionIds=['top','overview','services','approach','redesign','project-planner','finish'];
const pageSections=sectionIds.map(id=>document.getElementById(id)).filter(Boolean);
const isLandingPage=Boolean(document.querySelector('main#main > section#top.hero'))&&pageSections.length===sectionIds.length;
const sectionRail=document.querySelector('.section-rail');
const railLinks=[...document.querySelectorAll('[data-rail-for]')];
const railCurrent=document.querySelector('.section-rail__current');
const mobileProgress=document.querySelector('.mobile-section-progress');
const progressSegments=[...document.querySelectorAll('.mobile-section-progress span')];
const guidedMotion=window.matchMedia('(min-width: 1024px) and (prefers-reduced-motion: no-preference)');
let activeSectionIndex=0;
let sectionFramePending=false;
function updateCurrentSection(){
  sectionFramePending=false;
  const viewportMiddle=window.innerHeight*.53;
  let current=pageSections[0];
  let distance=Infinity;
  for(const section of pageSections){const rect=section.getBoundingClientRect();const gap=rect.top<=viewportMiddle&&rect.bottom>=viewportMiddle?0:Math.min(Math.abs(rect.top-viewportMiddle),Math.abs(rect.bottom-viewportMiddle));if(gap<distance){distance=gap;current=section}}
  if(!current)return;
  const index=sectionIds.indexOf(current.id);
  activeSectionIndex=index;
  const activeLink=railLinks[index];
  for(const link of railLinks){if(link===activeLink)link.setAttribute('aria-current','location');else link.removeAttribute('aria-current')}
  if(railCurrent)railCurrent.textContent=activeLink?.getAttribute('aria-label')||'';
  if(sectionRail)sectionRail.style.setProperty('--rail-progress',String(index/(pageSections.length-1)));
  const inverse=current.id==='redesign'||current.id==='finish';
  if(sectionRail)sectionRail.dataset.tone=inverse?'inverse':'normal';
  if(mobileProgress)mobileProgress.dataset.tone=inverse?'inverse':'normal';
  progressSegments.forEach((segment,segmentIndex)=>segment.classList.toggle('is-active',segmentIndex===index));
  pageSections.forEach(section=>section.classList.toggle('is-current',section===current));
}
function queueSectionUpdate(){if(sectionFramePending)return;sectionFramePending=true;requestAnimationFrame(updateCurrentSection)}
if(isLandingPage){
  window.addEventListener('scroll',queueSectionUpdate,{passive:true});
  window.addEventListener('resize',queueSectionUpdate);
  updateCurrentSection();
  document.body.classList.add('has-section-motion');
}

const headerHeight=()=>document.querySelector('.site-header')?.getBoundingClientRect().height||76;
let movingUntil=0;
function goToSection(index){
  const target=pageSections[Math.max(0,Math.min(index,pageSections.length-1))];
  if(!target)return;
  movingUntil=performance.now()+690;
  const top=target.id==='top'?0:window.scrollY+target.getBoundingClientRect().top-headerHeight();
  window.scrollTo({top,behavior:guidedMotion.matches?'smooth':'instant'});
}

let wheelTotal=0;
let wheelConsumed=false;
let wheelReset;
function resetWheelGesture(){wheelTotal=0;wheelConsumed=false}
function queueWheelReset(){clearTimeout(wheelReset);wheelReset=setTimeout(resetWheelGesture,190)}
window.addEventListener('wheel',event=>{
  if(!isLandingPage||!guidedMotion.matches||event.ctrlKey||event.target.closest('input,textarea,select,[contenteditable="true"]'))return;
  const direction=Math.sign(event.deltaY);
  if(!direction)return;
  if(performance.now()<movingUntil){event.preventDefault();wheelConsumed=true;queueWheelReset();return}
  const current=pageSections[activeSectionIndex];
  const rect=current?.getBoundingClientRect();
  if(rect&&((direction>0&&rect.bottom>innerHeight+4)||(direction<0&&rect.top<headerHeight()-4)))return;
  event.preventDefault();
  queueWheelReset();
  if(wheelConsumed||performance.now()<movingUntil)return;
  wheelTotal+=event.deltaY*(event.deltaMode===1?16:event.deltaMode===2?innerHeight:1);
  if(Math.abs(wheelTotal)<35)return;
  wheelConsumed=true;
  wheelTotal=0;
  goToSection(activeSectionIndex+direction);
},{passive:false});

window.addEventListener('keydown',event=>{
  if(!isLandingPage||!guidedMotion.matches||event.altKey||event.ctrlKey||event.metaKey||event.target.closest('input,textarea,select,button,[contenteditable="true"]'))return;
  const down=['ArrowDown','PageDown',' '].includes(event.key);
  const up=['ArrowUp','PageUp'].includes(event.key);
  if(!down&&!up&&event.key!=='Home'&&event.key!=='End')return;
  const rect=pageSections[activeSectionIndex]?.getBoundingClientRect();
  if(rect&&((down&&rect.bottom>innerHeight+4)||(up&&rect.top<headerHeight()-4)))return;
  event.preventDefault();
  if(event.repeat||performance.now()<movingUntil)return;
  goToSection(event.key==='Home'?0:event.key==='End'?pageSections.length-1:activeSectionIndex+(down?1:-1));
});

