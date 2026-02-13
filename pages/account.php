<div class="profile-header">
    <div class="profile-avatar">
        <i class="fa-solid fa-user-secret"></i>
    </div>
    <div class="profile-info">
        <h1>John Doe</h1> <p class="email">john.doe@exemple.com</p>
        
        <div class="badges">
            <span class="badge badge-role">Utilisateur</span>
            <span class="badge badge-solde">Solde : 150.00 €</span>
        </div>
    </div>
    <div class="profile-actions">
        <button class="btn-primary"><i class="fa-solid fa-wallet"></i> Ajouter Fonds</button>
    </div>
</div>

<h2 class="section-title"><i class="fa-solid fa-box-open"></i> Mes Articles en vente</h2>

<div class="grid-articles">
    <div class="article-box">
        <div style="text-align:center;">
            <i class="fa-solid fa-person-rifle" style="font-size: 2rem; color: #555;"></i>
            <p style="margin-top:10px;">Gilet Tactique</p>
            <small style="color: var(--bg-olive-light);">45.00 €</small>
        </div>
    </div>

    <div class="article-box">
        <div style="text-align:center;">
            <i class="fa-solid fa-binoculars" style="font-size: 2rem; color: #555;"></i>
            <p style="margin-top:10px;">Jumelles X200</p>
            <small style="color: var(--bg-olive-light);">120.00 €</small>
        </div>
    </div>
    
    <div class="article-box" style="border-style: dashed; opacity: 0.5;">
        <div style="text-align:center;">
            <i class="fa-solid fa-plus" style="font-size: 2rem;"></i>
            <p>Vendre un item</p>
        </div>
    </div>
</div>

<h2 class="section-title"><i class="fa-solid fa-gear"></i> Modifier mes informations</h2>

<div class="dark-form">
    <form action="" method="POST">
        <div class="form-group">
            <label>Nom d'utilisateur</label>
            <input type="text" value="John Doe" disabled style="opacity: 0.5; cursor: not-allowed;">
            <small style="color: #666;">Le nom d'utilisateur n'est pas modifiable.</small>
        </div>

        <div class="form-group">
            <label>Adresse Email</label>
            <input type="email" value="john.doe@exemple.com">
        </div>

        <div class="form-group">
            <label>Nouveau mot de passe (Laisser vide pour ne pas changer)</label>
            <input type="password" placeholder="********">
        </div>
        
        <button type="submit" class="btn-primary">Enregistrer les modifications</button>
    </form>
</div>

<h2 class="section-title"><i class="fa-solid fa-file-invoice"></i> Mes Factures</h2>

<table class="table-dark">
    <thead>
        <tr>
            <th>Date</th>
            <th>Article</th>
            <th>Montant</th>
            <th>PDF</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>12/02/2025</td>
            <td>Sac à dos militaire</td>
            <td>89.99 €</td>
            <td><a href="#" style="color: var(--bg-olive-light);"><i class="fa-solid fa-download"></i></a></td>
        </tr>
        <tr>
            <td>10/01/2025</td>
            <td>Lampe Torche UV</td>
            <td>25.50 €</td>
            <td><a href="#" style="color: var(--bg-olive-light);"><i class="fa-solid fa-download"></i></a></td>
        </tr>
    </tbody>
</table>