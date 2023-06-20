const BASE_URL = "http://localhost:8081";

const getFruits = (params) => {
  let url = `${BASE_URL}/api/fruits`;
  if (Object.keys(params).length) {
    url += `?` + new URLSearchParams(params).toString();
  }

  return fetch(url).then(res => res.json());
}

const getFavoriteFruits = () => {
  return fetch(`${BASE_URL}/api/fruits/favorites`).then(res => res.json());
}

const getFamilies = () => {
  return fetch(`${BASE_URL}/api/fruit/families`).then(res => res.json());
}

const toggleFavorite = (id) => {
  return fetch(`${BASE_URL}/api/fruits/${id}/toggle-favorite`, {"method": "PUT"}).then(res => res.json());
}

export {
  getFruits,
  getFavoriteFruits,
  getFamilies,
  toggleFavorite
}
