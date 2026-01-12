-- ============================================
-- Script d'insertion des données pour ECP
-- Emballé c'est pesé - Produits de bio-nettoyage
-- ============================================

-- Nettoyage des tables (optionnel - décommenter si besoin)
-- TRUNCATE TABLE avis;
-- TRUNCATE TABLE produits;
-- TRUNCATE TABLE promo;
-- TRUNCATE TABLE type_produit;

-- ============================================
-- 1. Insertion des types de produits
-- ============================================
INSERT INTO type_produit (code_typ, lib_typ) VALUES
(1, 'Désherbants'),
(2, 'Nettoyants Sol'),
(3, 'Outils de jardin'),
(4, 'Engrais & Compost'),
(5, 'Pulvérisateurs'),
(6, 'Kits complets');

-- ============================================
-- 2. Insertion des promotions
-- ============================================
INSERT INTO promo (date_db, date_fin, reduc) VALUES
-- Promo hiver en cours (-33%)
('2025-12-01', '2026-02-28', 33.00),
-- Promo printemps à venir (-25%)
('2026-03-01', '2026-05-31', 25.00),
-- Promo été (-20%)
('2026-06-01', '2026-08-31', 20.00);

-- ============================================
-- 3. Insertion des produits
-- ============================================

-- Désherbants (subtils outils d'élimination)
INSERT INTO produits (ref_pds, qtepds, prix_pds, lib_pds, desc_pds, design_pds, code_typ_id, id_promo_id) VALUES
(1001, 15, 19.90, 'Désherbant Radical Bio',
 'Élimine tout en profondeur. Plus rien ne repousse. Jamais. Idéal pour les coins oubliés du jardin.',
 'desherbant.jpg',
 1,
 (SELECT id FROM promo WHERE reduc = 33.00 )),

(1002, 8, 24.90, 'Désherbant Express 2L',
 'Action rapide en 6 heures. Fait disparaître les mauvaises herbes sans laisser de traces. Odeur de terre fraîche.',
 'desherbant.jpg',
 1,
 NULL),

(1003, 3, 34.90, 'Concentré Ultime Pro',
 'Formule concentrée pour un nettoyage en profondeur. Une seule application suffit. Plus jamais besoin de revenir.',
 'desherbant.jpg',
 1,
 NULL);

-- Nettoyants sol (pour nettoyer les traces)
INSERT INTO produits (ref_pds, qtepds, prix_pds, lib_pds, desc_pds, design_pds, code_typ_id, id_promo_id) VALUES
(2001, 12, 24.90, 'Nettoyant Sol Express',
 'Fait disparaître les taches tenaces en quelques minutes. Parfait avant de semer du gazon. Efface même les traces de pas.',
 'sol.jpg',
 2,
 NULL),

(2002, 20, 16.90, 'Détachant Profond 1L',
 'Nettoie en profondeur toutes les surfaces. Idéal pour préparer un terrain parfaitement lisse et propre.',
 'sol.jpg',
 2,
 (SELECT id FROM promo WHERE reduc = 33.00 ));

-- Kits complets (outils discrets)
INSERT INTO produits (ref_pds, qtepds, prix_pds, lib_pds, desc_pds, design_pds, code_typ_id, id_promo_id) VALUES
(3001, 7, 39.90, 'Kit Jardinier Discret',
 'Contient gants renforcés, pelle pliable et sac compostable. Pour travailler la nuit sans bruit. Tout tient dans une boîte à chaussures.',
 'kit.jpg',
 6,
 (SELECT id FROM promo WHERE reduc = 33.00 )),

(3002, 4, 79.90, 'Pack Complet "Jardin Parfait"',
 'Tout ce qu il faut pour un terrain nickel en une seule commande. Best-seller. Livré en 3 colis séparés pour plus de discrétion.',
 'pack.jpg',
 6,
 (SELECT id FROM promo WHERE reduc = 33.00 )),

(3003, 10, 54.90, 'Kit Nettoyage Complet',
 'Ensemble professionnel pour un jardinage impeccable. Pelle, gants, sacs et outils de précision. Discrétion garantie.',
 'kit.jpg',
 6,
 NULL);

-- Engrais et compost (accélérateurs de décomposition)
INSERT INTO produits (ref_pds, qtepds, prix_pds, lib_pds, desc_pds, design_pds, code_typ_id, id_promo_id) VALUES
(4001, 25, 15.90, 'Engrais Silencieux',
 'Accélère la décomposition naturelle. Votre compost n a jamais été aussi... vide. Action en moins de 6 heures.',
 'engrais.jpg',
 4,
 NULL),

(4002, 18, 22.90, 'Activateur de Compost Pro',
 'Transforme rapidement tout en terre. Processus accéléré pour un résultat discret et définitif. Sans odeur suspecte.',
 'engrais.jpg',
 4,
 NULL),

(4003, 12, 28.90, 'Poudre Décomposition Rapide',
 'Formule professionnelle qui fait disparaître les matières organiques en quelques jours. Aucune trace, aucune question.',
 'engrais.jpg',
 4,
 (SELECT id FROM promo WHERE reduc = 33.00));

-- Pulvérisateurs (outils d'application)
INSERT INTO produits (ref_pds, qtepds, prix_pds, lib_pds, desc_pds, design_pds, code_typ_id, id_promo_id) VALUES
(5001, 9, 34.90, 'Pulvérisateur Pro 5m',
 'Portée 5 mètres, réservoir 2L. Pour traiter les grandes surfaces sans se fatiguer. Silencieux comme une brise.',
 'pulve.jpg',
 5,
 (SELECT id FROM promo WHERE reduc = 33.00)),

(5002, 14, 29.90, 'Spray Précision 3L',
 'Application ciblée et discrète. Réservoir grande capacité. Idéal pour les travaux nocturnes sans éveiller les soupçons.',
 'pulve.jpg',
 5,
 NULL),

(5003, 6, 44.90, 'Pulvérisateur Silence Plus',
 'Modèle professionnel ultra-silencieux. Portée 7 mètres. Système anti-goutte pour un travail propre et sans traces.',
 'pulve.jpg',
 5,
 NULL);

-- Outils de jardin (outils de précision)
INSERT INTO produits (ref_pds, qtepds, prix_pds, lib_pds, desc_pds, design_pds, code_typ_id, id_promo_id) VALUES
(6001, 11, 18.90, 'Pelle Pliable Renforcée',
 'Compacte et solide. Se plie pour tenir dans un sac à dos. Idéale pour creuser rapidement et discrètement.',
 'kit.jpg',
 3,
 NULL),

(6002, 8, 12.90, 'Gants Protection Pro',
 'Imperméables et résistants. Ne laissent aucune trace. Double épaisseur pour manipuler des produits puissants.',
 'kit.jpg',
 3,
 NULL),

(6003, 15, 9.90, 'Sacs Compostables Discrets',
 'Pack de 10 sacs opaques compostables. Grande contenance 100L. Se décomposent naturellement. Pas de traces.',
 'kit.jpg',
 3,
 (SELECT id FROM promo WHERE reduc = 33.00));

-- ============================================
-- 4. Quelques avis clients (optionnel)
-- ============================================
-- Note: Il faut avoir des utilisateurs dans la table 'utilisateurs' avant d'insérer des avis
-- Exemple si tu as un utilisateur avec id = 1 :
/*
INSERT INTO avis (note, commentaire, date, id_user, ref_pds) VALUES
(5, 'Produit efficace, résultats impressionnants. Plus de mauvaises herbes en 24h !', '2025-12-15', 1, 1001),
(5, 'Exactement ce que je cherchais pour mon jardin. Discret et efficace.', '2025-12-20', 1, 2001),
(4, 'Bon rapport qualité-prix. Le kit contient tout le nécessaire.', '2026-01-05', 1, 3001);
*/

-- ============================================
-- Vérification des données insérées
-- ============================================
SELECT 'Types de produits :' as Info, COUNT(*) as Total FROM type_produit
UNION ALL
SELECT 'Promotions :', COUNT(*) FROM promo
UNION ALL
SELECT 'Produits :', COUNT(*) FROM produits;

-- Afficher tous les produits avec leurs promotions
SELECT
    p.ref_pds,
    p.lib_pds,
    p.prix_pds,
    p.qtepds as stock,
    tp.lib_typ as type,
    COALESCE(pr.reduc, 0) as promo_reduc,
    CASE
        WHEN pr.id IS NOT NULL AND CURRENT_TIMESTAMP BETWEEN pr.date_db AND pr.date_fin
        THEN ROUND(p.prix_pds * (1 - pr.reduc/100), 2)
        ELSE p.prix_pds
    END as prix_final
FROM produits p
LEFT JOIN type_produit tp ON p.code_typ_id = tp.id
LEFT JOIN promo pr ON p.id_promo_id = pr.id
ORDER BY p.ref_pds;

-- ============================================
-- FIN DU SCRIPT
-- ============================================
