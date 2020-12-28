import React from 'react'
import phoneImg from './images/phone.svg'
import {useGlobalContext} from './context'

const Hero = () => {
  const {closeSubmenu} = useGlobalContext();
  
  return <section className="hero" onMouseOver={closeSubmenu}>
    <div className="hero-center">
      <article className="hero-info">
        <h1>Payments infrastructur for the internet</h1>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit ipsum tempore quas modi delectus minima commodi veniam quidem optio maiores!
        </p>
        <button className="btn">Start Now</button>
      </article>
      <article className="hero-images">
        <img src={phoneImg} className='phone-img' alt="phone"/>
      </article>
    </div>
  </section>
}

export default Hero
