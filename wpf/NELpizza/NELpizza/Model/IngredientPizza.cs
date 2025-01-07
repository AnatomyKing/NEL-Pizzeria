using System.ComponentModel.DataAnnotations.Schema;

namespace NELpizza.Model
{
    [Table("ingredient_pizza")]
    public class IngredientPizza
    {
        [ForeignKey("Ingredient")]
        [Column("ingredient_id", TypeName = "BIGINT UNSIGNED")]
        public long IngredientId { get; set; }
        public virtual Ingredient? Ingredient { get; set; }

        [ForeignKey("Pizza")]
        [Column("pizza_id", TypeName = "BIGINT UNSIGNED")]
        public long PizzaId { get; set; }
        public virtual Pizza? Pizza { get; set; }
    }
}
