{{foreach cardproducts}}
<div class="container">
    <div class="card">
        <div class="product-img">
          <img src="/public/imgs/SinFoto.jpg">
        </div>
        <div class="product-detail">
          <span>{{nom_prod}}</span>
          <p>{{desc_prod}}</p>
          <div class="buttons">
             <div class="price">{{precio}}</div>
             <button class="cart btn">Añadir al carrito</button>
          </div>
        </div>
    </div>
</div>
{{endfor cardproducts}}