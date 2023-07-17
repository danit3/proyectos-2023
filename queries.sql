-- Para la consulta del producto con más stock:

SELECT * FROM productos ORDER BY stock DESC LIMIT 1;


-- Para la consulta del producto más vendido:

SELECT p.*, SUM(v.cantidad) AS total_vendido
FROM productos p
JOIN ventas v ON p.id = v.producto_id
GROUP BY p.id
ORDER BY total_vendido DESC
LIMIT 1;
