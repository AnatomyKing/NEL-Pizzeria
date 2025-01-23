using System.Collections.Generic;
using System.Linq;
using NELpizza.Model;

namespace NELpizza.Models
{
    public class PizzaManager
    {
        private readonly List<Pizza> _pizzas;

        public PizzaManager()
        {
            _pizzas = new List<Pizza>
            {
                new Pizza { Id = 1, Naam = "Margherita", Prijs = 8.99M, Beschrijving = "Tomato, Mozzarella" },
                new Pizza { Id = 2, Naam = "Pepperoni", Prijs = 9.99M, Beschrijving = "Pepperoni, Mozzarella" }
            };
        }

        public List<Pizza> GetPizzas() => _pizzas;

        public void AddPizza(Pizza pizza)
        {
            pizza.Id = _pizzas.Count > 0 ? _pizzas.Max(p => p.Id) + 1 : 1;
            _pizzas.Add(pizza);
        }

        public void UpdatePizza(long id, Pizza updatedPizza)
        {
            var pizza = _pizzas.FirstOrDefault(p => p.Id == id);
            if (pizza != null)
            {
                pizza.Naam = updatedPizza.Naam;
                pizza.Prijs = updatedPizza.Prijs;
                pizza.Beschrijving = updatedPizza.Beschrijving;
            }
        }

        public void DeletePizza(long id)
        {
            var pizza = _pizzas.FirstOrDefault(p => p.Id == id);
            if (pizza != null)
            {
                _pizzas.Remove(pizza);
            }
        }
    }
}
