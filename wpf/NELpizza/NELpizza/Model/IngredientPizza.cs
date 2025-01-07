using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;
using System.Threading.Tasks;


namespace NELpizza.Model
{
    [Table("ingredient_pizza")]
    public class IngredientPizza
    {
        public long pizza_id { get; set; }
        public virtual Pizza? pizza { get; set; }

        public long ingredient_id { get; set; }
        public virtual Ingredient? ingredient { get; set; }
    }
}